{{-- Section: reviews | Design 1 (extracted original) --}}
<!-- ================= CUSTOMER REVIEWS ================= -->
    @php
        $rvEyebrow = ab_t('reviews_eyebrow', 'গ্রাহকদের মতামত', 'Customer Opinions');
        $rvH2a = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ");
        $rvH2b = ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews');
        $rvSub = ab_t('reviews_sub', 'সারা বাংলাদেশ থেকে আমাদের মূল্যবান গ্রাহকদের অভিজ্ঞতা', 'Experiences of our valued customers from all over Bangladesh');
        $rvScore = ab_t('rating_score', '৪.৯', '4.9');
        $rvTotal = ab_t('rating_total', '৫৩২টি ভেরিফাইড রিভিউ', 'Based on 532 verified reviews');
        $reviewCards = ab_json('reviews_items', ab_reviews_default());

        // rating summary auto-computed from the review cards (no manual bars needed)
        $revN = count($reviewCards);
        $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $starSum = 0;
        foreach ($reviewCards as $rc) {
            $st = max(1, min(5, (int) ($rc['stars'] ?? 5)));
            $starCounts[$st]++;
            $starSum += $st;
        }
        $avgRating = $revN ? round($starSum / $revN, 1) : 5.0;
        $autoBars = [];
        foreach ([5, 4, 3, 2, 1] as $st) {
            $cnt = $starCounts[$st];
            $autoBars[] = [
                'star' => $st,
                'pct' => $revN ? round($cnt * 100 / $revN) : 0,
                'count_bn' => bn_num($cnt),
                'count_en' => (string) $cnt,
            ];
        }
        $ratingBars = $autoBars;
        $starSvgFull = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        $starSvgHalf = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
    @endphp
    <section id="ds-reviews" class="py-16 bg-white overflow-hidden w-full">
        <div class="ds-sec-head">
            <span class="ds-eyebrow" data-en="{{ $rvEyebrow['en'] }}">{{ $rvEyebrow['bn'] }}</span>
            <h2 class="ds-h2"><span data-en="{{ $rvH2a['en'] }}">{{ $rvH2a['bn'] }}</span><span class="ds-grad" data-en="{{ $rvH2b['en'] }}">{{ $rvH2b['bn'] }}</span></h2>
            <p class="ds-sub" data-en="{{ $rvSub['en'] }}">{{ $rvSub['bn'] }}</p>
        </div>

        <div class="rating-summary">
            <div class="rs-score">
                <div class="rs-big">{{ bn_num($avgRating) }}<span data-en="/5">/৫</span></div>
                <div class="rs-stars">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="rs-total" data-en="Based on {{ $revN }} verified reviews">{{ bn_num($revN) }} টি ভেরিফাইড রিভিউ</div>
            </div>
            <div class="rs-bars">
                @foreach ($ratingBars as $bar)
                    <div class="rs-bar">
                        <span class="rs-l">{{ bn_num($bar['star'] ?? 0) }} <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                        <span class="rs-track"><span class="rs-fill" data-w="{{ $bar['pct'] ?? 0 }}"></span></span>
                        <span class="rs-n">{{ $bar['count_bn'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="reviews-swiper swiper w-full !overflow-hidden">
            <div class="swiper-wrapper">

                @foreach ($reviewCards as $rev)
                    <div class="swiper-slide px-2 md:px-3">
                        <div
                            class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ asset($rev['img'] ?: 'assets/img/rev1.jpg') }}" alt="{{ $rev['name'] ?? '' }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-bold text-sm text-[#d97706]">{{ $rev['name'] ?? '' }} <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                    <p class="text-[10px] text-gray-500" data-en="{{ $rev['loc_en'] ?? '' }}">{{ $rev['loc_bn'] ?? '' }}</p>
                                    @if (($rev['source'] ?? 'normal') === 'google')
                                        <span class="inline-flex items-center gap-1 mt-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded-full border" style="border-color:#4285F4;color:#4285F4" data-en="Google Review">গুগল রিভিউ</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mb-3 flex-1" data-en="{{ $rev['text_en'] ?? '' }}">
                                {{ $rev['text_bn'] ?? '' }}
                            </p>
                            <div class="flex items-center text-xs text-yellow-500 mb-2">
                                @for ($si = 1; $si <= 5; $si++)
                                    {!! ($si <= (int) ($rev['stars'] ?? 5)) ? $starSvgFull : $starSvgHalf !!}
                                @endfor
                                <span class="ml-2 text-gray-600 font-semibold" data-en="{{ $rev['stars'] ?? 5 }}/5">{{ bn_num($rev['stars'] ?? 5) }}/৫</span>
                            </div>
                            <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                                <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="{{ $rev['likes_en'] ?? '' }}">{{ $rev['likes_bn'] ?? '' }}</span></span>
                                <span data-en="Reply">Reply</span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </section>
