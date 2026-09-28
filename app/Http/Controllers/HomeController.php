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
