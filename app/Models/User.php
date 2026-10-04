<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';

    /**
     * Sidebar-section permissions — key => Bangla label (checkbox UI + middleware).
     * Dashboard sob admin er jonno khola, tai ekhane nai.
     */
    public const PERMISSIONS = [
        'orders' => 'অর্ডারসমূহ',
        'complaints' => 'কমপ্লেইন',
        'products' => 'প্রোডাক্ট',
        'suppliers' => 'সাপ্লায়ার',
        'customers' => 'গ্রাহক',
        'taxonomy' => 'ক্যাটাগরি ও ব্র্যান্ড',
        'coupons' => 'কুপন',
        'delivery' => 'ডেলিভারি এরিয়া',
        'reviews' => 'রিভিউ',
        'payment' => 'পেমেন্ট গেটওয়ে',
        'tracking' => 'ট্র্যাকিং ও পিক্সেল',
        'content' => 'ল্যান্ডিং কনটেন্ট',
        'sections' => 'সেকশন ডিজাইন',
        'brand' => 'লোগো ও ব্র্যান্ড',
        'theme' => 'থিম কালার',
        'seo' => 'SEO',
        'robots' => 'robots.txt',
        'redirects' => '301 Redirects',
        'sitemap' => 'Sitemap',
        'admins' => 'অ্যাডমিন ম্যানেজমেন্ট',
    ];

    /**
     * Role presets — dropdown theke select korlei checkbox gulo auto-fill hoy.
     * DB te sudhu permissions save hoy (role = preset er sathe match kore dekhao).
     */
    public const ROLE_PRESETS = [
        'admin' => [
            'label' => 'Admin — সব এক্সেস',
            'perms' => null, // null = all keys
        ],
        'manager' => [
            'label' => 'Manager — অর্ডার, প্রোডাক্ট, গ্রাহক',
            'perms' => ['orders', 'complaints', 'products', 'suppliers', 'customers', 'taxonomy', 'coupons', 'delivery', 'reviews'],
        ],
        'sub_admin' => [
            'label' => 'Sub Admin — অর্ডার ও প্রোডাক্ট',
            'perms' => ['orders', 'products', 'customers'],
        ],
    ];

    /** Ei permission set kon role preset er sathe mille seta return kore (nahole 'custom'). */
    public function roleLabel(): string
    {
        $perms = $this->permissions ?? [];
        $all = array_keys(self::PERMISSIONS);
        sort($perms);
        foreach (self::ROLE_PRESETS as $preset) {
            $presetPerms = $preset['perms'] ?? $all;
            sort($presetPerms);
            if ($perms === $presetPerms) {
                return trim(explode('—', $preset['label'])[0]);
            }
        }
        return 'Custom';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role',
        'permissions',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Legacy code paths (ar purano test-gulo) admin banay purano niyome —
        // User::create e permissions array, role chara. Setake client admin
        // dhorbo; role/permission kichu na dile customer (least privilege).
        static::creating(function (User $user) {
            $user->role ??= (filled($user->permissions) ? self::ROLE_ADMIN : self::ROLE_CUSTOMER);
            $user->is_active ??= true;
        });
    }

    /* ================= Role helpers ================= */

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    /**
     * Permission check for a "<module>.<feature>" action string (config/permissions.php).
     * super_admin → always true; admin → checks the JSON map where a module maps
     * to a feature list and ["*"] (or the string "*") grants the whole module;
     * customer → always false.
     */
    public function hasPermission(string $moduleAction): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->isAdmin()) {
            return false;
        }

        [$module, $feature] = array_pad(explode('.', $moduleAction, 2), 2, null);
        if ($module === null || $feature === null) {
            return false;
        }

        $granted = $this->permissionMap()[$module] ?? null;

        if ($granted === '*') {
            return true;
        }

        if (! is_array($granted)) {
            return false;
        }

        return in_array('*', $granted, true) || in_array($feature, $granted, true);
    }

    /** Whether the user holds ANY permission inside a module (sidebar rendering). */
    public function hasAnyModulePermission(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->isAdmin()) {
            return false;
        }

        $granted = $this->permissionMap()[$module] ?? null;

        return $granted === '*' || (is_array($granted) && count($granted) > 0);
    }

    /* ================= Legacy flat-key shims (pre-role installs) ================= */

    /**
     * permissions JSON দুই যুগের দুই shape: পুরনো ইনস্টলে flat লিস্ট ছিল
     * (["orders","products"]) — প্রতিটা entry কে পুরো মডিউল গ্র্যান্ট ধরা হয়
     * যেন পুরনো row গুলো data রিরাইট ছাড়াই কাজ চালাতে পারে।
     */
    private function permissionMap(): array
    {
        $perms = $this->permissions ?? [];

        return array_is_list($perms) ? array_fill_keys($perms, '*') : $perms;
    }

    /** Ei admin er ei module/module.feature er access ase kina — flat section key o chole. */
    public function hasPerm(string $key): bool
    {
        return str_contains($key, '.') ? $this->hasPermission($key) : $this->hasAnyModulePermission($key);
    }

    /** Ekadhor key thakle true (sidebar group dekhate). */
    public function hasAnyPerm(array $keys): bool
    {
        foreach ($keys as $key) {
            if ($this->hasPerm($key)) {
                return true;
            }
        }

        return false;
    }

    /** Bengali summary for the super-admin list (e.g. "অর্ডার (২ ফিচার), প্রোডাক্ট (৪ ফিচার) +২ টি মডিউল"). */
    public function permissionsSummary(): string
    {
        if ($this->isSuperAdmin()) {
            return 'সব অনুমতি';
        }

        $modules = array_keys($this->permissionMap());
        if ($modules === []) {
            return 'কোনো অনুমতি নেই';
        }

        $labels = array_map(
            fn ($m) => $this->moduleSummaryLabel($m),
            array_intersect($modules, array_keys(config('permissions.modules', [])))
        );

        if (count($labels) <= 3) {
            return implode(', ', $labels);
        }

        return implode(', ', array_slice($labels, 0, 3)) . ' +' . (count($labels) - 3) . ' টি মডিউল';
    }

    /** "থিম (৪ ফিচার)" — module label + how many of its features are granted. */
    private function moduleSummaryLabel(string $module): string
    {
        $label = config("permissions.modules.$module.label", $module);
        $features = config("permissions.modules.$module.features", []);
        $granted = $this->permissionMap()[$module] ?? [];

        $count = ($granted === '*' || in_array('*', (array) $granted, true))
            ? count($features)
            : count(array_intersect(array_keys($features), (array) $granted));

        return $label . ' (' . bn_num($count) . ' ফিচার)';
    }

    /* ================= Relationships ================= */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /* ================= Password reset (Bengali mail, log driver friendly) ================= */

    public function sendPasswordResetNotification($token): void
    {
        if (! $this->email) {
            return; // phone-only accounts cannot self-reset
        }

        $url = url(route('password.reset', ['token' => $token, 'email' => $this->email]));

        Mail::raw(
            "আসসালামু আলাইকুম {$this->name},\n\n"
            . "আপনার পাসওয়ার্ড রিসেট করার অনুরোধ পাওয়া গেছে। নিচের লিংকে ক্লিক করে নতুন পাসওয়ার্ড সেট করুন:\n\n"
            . $url . "\n\n"
            . "আপনি যদি এই অনুরোধ না করে থাকেন তাহলে এই ইমেইল উপেক্ষা করুন — পাসওয়ার্ড অপরিবর্তিত থাকবে।",
            fn ($message) => $message->to($this->email)->subject('পাসওয়ার্ড রিসেট — ' . ab_brand('bn'))
        );
    }
}
