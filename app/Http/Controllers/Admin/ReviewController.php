<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index', [
            'reviewRows' => ab_json('reviews_items', ab_reviews_default()),
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'reviews_json' => 'nullable|string|max:60000',
        ]);

        $rows = json_decode((string) $data['reviews_json'], true);
        $rows = is_array($rows) ? $rows : [];

        $clean = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $clean[] = [
                'name' => substr((string) ($row['name'] ?? ''), 0, 80),
                'img' => substr((string) ($row['img'] ?? ''), 0, 200),
                'stars' => max(1, min(5, (int) ($row['stars'] ?? 5))),
                'source' => ($row['source'] ?? 'normal') === 'google' ? 'google' : 'normal',
                'loc_bn' => substr((string) ($row['loc_bn'] ?? ''), 0, 120),
                'loc_en' => substr((string) ($row['loc_en'] ?? ''), 0, 120),
                'text_bn' => substr((string) ($row['text_bn'] ?? ''), 0, 600),
                'text_en' => substr((string) ($row['text_en'] ?? ''), 0, 600),
                'likes_bn' => substr((string) ($row['likes_bn'] ?? ''), 0, 40),
                'likes_en' => substr((string) ($row['likes_en'] ?? ''), 0, 40),
            ];
        }

        Setting::setMany([
            'reviews_items' => json_encode($clean, JSON_UNESCAPED_UNICODE),
        ]);

        return back()->with('success', 'রিভিউ সেভ হয়েছে — রেটিং বার ও সংখ্যা অটো হিসাব হয়ে গেছে।');
    }
}
