<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
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
        ];
    }

    /** Ei admin er ei section er permission ase kina. */
    public function hasPerm(string $key): bool
    {
        return in_array($key, $this->permissions ?? [], true);
    }

    /** Ekadhor section er jekono permission thakle true (sidebar group dekhate). */
    public function hasAnyPerm(array $keys): bool
    {
        foreach ($keys as $key) {
            if ($this->hasPerm($key)) return true;
        }
        return false;
    }
}
