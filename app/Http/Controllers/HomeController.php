<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SectionDesignLibrary;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::active()->forIndustry()->with('variants')->orderByDesc('is_featured')->get();

        return view('home', ['products' => $products, 'qv' => buildQuickView($products)]);
    }

    /** Footer er legal pages — content Setting e thakle seta, nahole default. */
    public function about()
    {
        return view('pages.legal', [
            'title' => 'আমাদের সম্পর্কে',
            'titleEn' => 'About Us',
            // admin ja likhbe setai — khali hole brand-friendly default
            'content' => trim((string) \App\Models\Setting::get('about_us_content', '')) !== ''
                ? \App\Models\Setting::get('about_us_content')
                : '<p><b>' . e(ab_brand('bn')) . '</b></p>' . DEFAULT_ABOUT_CONTENT,
        ]);
    }

    public function privacy()
    {
        return view('pages.legal', [
            'title' => 'প্রাইভেসি পলিসি',
            'titleEn' => 'Privacy Policy',
            'content' => \App\Models\Setting::get('privacy_policy_content', DEFAULT_PRIVACY_CONTENT),
        ]);
    }

    public function terms()
    {
        return view('pages.legal', [
            'title' => 'শর্তাবলি ও নিয়মাবলি',
            'titleEn' => 'Terms & Conditions',
            'content' => \App\Models\Setting::get('terms_content', DEFAULT_TERMS_CONTENT),
        ]);
    }

    /** Isolated single-section render for the admin Section Design Studio preview. */
    public function previewSection(Request $request, string $section): View
    {
        abort_unless(array_key_exists($section, SectionDesignLibrary::sections()), 404);

        $allowed = SectionDesignLibrary::discovered($section);
        $design = (int) $request->query('design', 1);
        if (! in_array($design, $allowed, true)) {
            $design = 1;
        }

        $products = Product::active()->forIndustry()->with('variants')->orderByDesc('is_featured')->get();

        return view('sections.preview', [
            'section' => $section,
            'design' => $design,
            'sectionView' => view()->exists("sections.{$section}.design-{$design}")
                ? "sections.{$section}.design-{$design}"
                : "sections.{$section}.design-1",
            'products' => $products,
            'qv' => buildQuickView($products),
        ]);
    }
}
