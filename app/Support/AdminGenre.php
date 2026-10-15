<?php

namespace App\Support;

use App\Http\Controllers\Admin\IndustryPack;
use App\Models\User;
use App\Services\ShowcaseSync;
use Illuminate\Support\Facades\DB;

/**
 * Admin-side genre context for the showcase demo admins
 * (demo.<genre>@khorak.shop). While such an admin is logged in, the panel
 * and their landing view resolve as THAT genre's store — genre-pack
 * defaults overlaid by their personal sandbox edits — while every write
 * lands in users.demo_settings and the real `settings` table (the actual
 * store) is never touched.
 *
 * Resolution is request-derived off the authenticated user (never sticky
 * statics), so guests, super admins and unbound admins see the global
 * store exactly as before, and nothing leaks between requests.
 */
class AdminGenre
{
    /** memoized per-request resolution (request+user scoped, test-safe) */
    private static ?array $memo = null;
    private static $memoReq = null;
    private static $memoUserId = null;

    /** Bound genre key for THIS request's authenticated demo admin, or null. */
    public static function active(): ?string
    {
        $resolved = self::resolve();

        return $resolved[0];
    }

    /**
     * Effective sandbox settings for the bound admin: what applyIndustry()
     * WOULD write for the genre (theme tokens, pack copy, hero images,
     * marquee/reviews, demo brand, no logo/contacts) merged under the
     * admin's own demo_settings edits. Null when no admin genre context.
     */
    public static function settings(): ?array
    {
        $resolved = self::resolve();

        return $resolved[1];
    }

    /** Sandbox write path — only ever called when a context is active. */
    public static function put(string $key, $value): void
    {
        [$genre, $settings] = self::resolve();
        if ($genre === null) {
            return; // caller guards this, but never fall through to global
        }

        $settings[$key] = $value;
        self::persist($settings);
        self::$memo = null; // next read sees the fresh blob
    }

    /** Bulk sandbox write (setMany equivalent). */
    public static function putMany(array $pairs): void
    {
        [$genre, $settings] = self::resolve();
        if ($genre === null) {
            return;
        }

        self::persist($pairs + $settings); // incoming writes WIN over pack defaults
        self::$memo = null;
    }

    /** Clear a genre demo admin's sandbox back to pack defaults. */
    public static function reset(string $genre): int
    {
        return User::where('email', ShowcaseSync::demoAdminEmail($genre))
            ->update(['demo_settings' => null]);
    }

    /* ================= internals ================= */

    private static function resolve(): array
    {
        $req = request();
        $userId = $req?->user()?->id;
        if (self::$memo !== null && self::$memoReq === $req && self::$memoUserId === $userId) {
            return self::$memo;
        }
        self::$memoReq = $req;
        self::$memoUserId = $userId;

        $user = $req?->user();
        $genre = null;
        $settings = null;

        if ($user && $user->isAdmin() && !$user->isSuperAdmin()) {
            $industry = $user->industry;
            if (is_string($industry) && $industry !== '' && IndustryPack::valid($industry)) {
                $genre = $industry;
                $settings = self::packDefaults($industry);

                $blob = json_decode((string) $user->demo_settings, true);
                if (is_array($blob)) {
                    $settings = array_merge($settings, $blob);
                }
            }
        }

        return self::$memo = [$genre, $settings];
    }

    private static function persist(array $settings): void
    {
        $user = request()?->user();
        if (!$user) {
            return;
        }

        User::where('id', $user->id)->update([
            'demo_settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
        ]);
    }

    /**
     * The settings applyIndustry() would write for a genre — minus the
     * deactivations. Mirrors Admin\SettingController::applyIndustry().
     */
    private static function packDefaults(string $genre): array
    {
        $pack = IndustryPack::all()[$genre];
        $theme = \App\Http\Controllers\Admin\ThemeLibrary::get($pack['theme']);

        $map = [
            'industry' => $genre,
            'theme_id' => $pack['theme'],
            'theme_json' => json_encode($theme, JSON_UNESCAPED_UNICODE),

            // demo brand — real store brand/logo/contacts never leak in
            'brand_bn1' => $pack['brand_bn'], 'brand_bn2' => '',
            'brand_en1' => $pack['brand_en'], 'brand_en2' => '',
            'logo_path' => '',
            'made_by_name' => '',
            'contact_phone' => '', 'contact_whatsapp' => '', 'contact_messenger' => '', 'contact_facebook' => '',

            'font_body' => 'hind', 'font_heading' => '',

            // baseline surface = the genre demo look: kono festive schedule
            // bade design-1 sob section visible (sandbox edit gulo blob e jay)
            'festive_schedule' => '[]',
            'section_designs' => '{}',
            'sections_hidden' => '[]',

            'marquee_items' => json_encode(array_map(
                fn ($m) => ['bn' => $m[0], 'en' => $m[1]],
                IndustryPack::marquee($genre)
            ), JSON_UNESCAPED_UNICODE),
            'reviews_items' => json_encode(IndustryPack::reviews($genre), JSON_UNESCAPED_UNICODE),
        ];

        foreach (IndustryPack::slots() as $slotKey => $file) {
            $map[$slotKey] = 'assets/img/genres/' . $genre . '/' . $file;
        }

        $content = $pack['content'];
        foreach (IndustryPack::heroSlides($genre) as $sk => $sv) {
            if ($sv !== null) {
                $content[$sk] = $sv;
            }
        }
        foreach ($content as $k => $v) {
            $map[$k . '_bn'] = $v[0];
            $map[$k . '_en'] = $v[1];
        }

        return $map;
    }
}
