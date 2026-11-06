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
     * The platform owner (khorak). A delete-protected account can only be
     * removed by this account — not by any other super admin or admin.
     * Same seeded owner the debug panel guards on.
     */
    public const PLATFORM_OWNER_EMAIL = 'admin@khorak.shop';

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
     * Flat-list keys (above) that were renamed when permissions became
     * module.feature maps — a legacy "all sections" admin keeps all of them.
     */
    public const LEGACY_MODULE_KEYS = [
        'brand' => 'brand_settings',
        'admins' => 'team',
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
        'is_protected',
        'created_by',
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
            'is_protected' => 'boolean',
            'created_by' => 'integer',
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

    /** The one platform owner (khorak) — only account allowed to delete protected users. */
    public function isPlatformOwner(): bool
    {
        return $this->isSuperAdmin() && $this->email === self::PLATFORM_OWNER_EMAIL;
    }

    /* ================= Team hierarchy (who created whom) ================= */

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    /**
     * IDs of every staff account this user created — and, recursively, the
     * accounts their team created. Customers are never part of a team.
     */
    public function teamIds(): array
    {
        $ids = [];
        $frontier = [$this->id];

        while ($frontier !== []) {
            $children = static::whereIn('created_by', $frontier)
                ->where('role', '!=', self::ROLE_CUSTOMER)
                ->pluck('id')->all();

            // cycle guard — created_by is set once at creation, but stay safe
            $frontier = array_values(array_diff($children, $ids, [$this->id]));
            $ids = array_merge($ids, $frontier);
        }

        return $ids;
    }

    /**
     * The head of this user's team: follow the creators up to the account the
     * platform provisioned. Never climbs past a non-admin, so the owner stays out.
     */
    public function teamRoot(): self
    {
        $root = $this;
        $seen = [$this->id];

        while ($root->created_by && ! in_array($root->created_by, $seen, true)) {
            $parent = static::find($root->created_by);
            if (! $parent || ! $parent->isAdmin()) {
                break;
            }

            $seen[] = $parent->id;
            $root = $parent;
        }

        return $root;
    }

    /**
     * Everyone in this user's team — its head and the whole tree under it,
     * themselves included. Teammates see each other; managing an account still
     * goes through canManageUser() (only the ones you or your team created).
     */
    public function visibleTeamIds(): array
    {
        $root = $this->teamRoot();

        return [$root->id, ...$root->teamIds()];
    }

    /**
     * Whether this user may open/edit/delete another account in admin
     * management. Super admin: any staff account. Client admin: only their own
     * team — never themselves (no self-escalation), never a super admin.
     */
    public function canManageUser(self $target): bool
    {
        if ($target->isCustomer()) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->isAdmin() || $target->isSuperAdmin()) {
            return false;
        }

        return in_array($target->id, $this->teamIds(), true);
    }

    /**
     * module => feature list this user may hand out. Super admin: everything;
     * client admin: only what they hold themselves.
     */
    public function grantableMap(): array
    {
        $map = [];

        foreach (config('permissions.modules', []) as $module => $info) {
            $features = array_keys($info['features']);
            $map[$module] = $this->isSuperAdmin()
                ? $features
                : array_values(array_filter($features, fn ($f) => $this->hasPermission("$module.$f")));
        }

        return $map;
    }

    /**
     * Cap a permission map (module => ['*'] | features) to what the granter
     * may give. Capped modules get explicit feature lists, so a grant never
     * silently widens when a module gains new features later.
     */
    public static function capPermissions(array $perms, array $grantable): array
    {
        $capped = [];

        foreach ($perms as $module => $features) {
            $allowed = $grantable[$module] ?? [];
            $features = (array) $features;
            $chosen = in_array('*', $features, true)
                ? $allowed
                : array_values(array_intersect($allowed, $features));

            if ($chosen !== []) {
                $capped[$module] = $chosen;
            }
        }

        return $capped;
    }

    /**
     * After this user's permissions change, shrink their team to match:
     * nobody may ever hold more than the account that created them.
     */
    public function trimTeamPermissions(array $seen = []): void
    {
        $seen[] = $this->id;
        $grantable = $this->grantableMap();

        foreach (static::where('created_by', $this->id)->where('role', self::ROLE_ADMIN)->get() as $member) {
            if (in_array($member->id, $seen, true)) {
                continue;
            }

            $capped = self::capPermissions($member->permissionMap(), $grantable);
            if ($capped != ($member->permissions ?? [])) {
                $member->permissions = $capped;
                $member->save();
            }

            $member->trimTeamPermissions($seen);
        }
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
        if (! array_is_list($perms)) {
            return $perms;
        }

        $map = [];
        foreach ($perms as $module) {
            $map[self::LEGACY_MODULE_KEYS[$module] ?? $module] = '*';
        }

        return $map;
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
