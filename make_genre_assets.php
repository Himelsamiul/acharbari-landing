<?php
// One-off generator: creates premium demo SVG assets for every industry pack.
// run: php make_genre_assets.php   (safe to re-run — regenerates all files)

$G = [
    'organic' => ['c1' => '#059669', 'c2' => '#84cc16', 'c3' => '#064e3b', 'bg1' => '#ecfdf5', 'bg2' => '#d1fae5', 'glyph' => 'jar'],
    'restaurant' => ['c1' => '#c2410c', 'c2' => '#fbbf24', 'c3' => '#7c2d12', 'bg1' => '#fff7ed', 'bg2' => '#ffedd5', 'glyph' => 'plate'],
    'fashion' => ['c1' => '#9d174d', 'c2' => '#d4a437', 'c3' => '#1f2937', 'bg1' => '#fdf2f8', 'bg2' => '#e5e7eb', 'glyph' => 'shirt'],
    'beauty' => ['c1' => '#db2777', 'c2' => '#c026d3', 'c3' => '#500724', 'bg1' => '#fdf2f8', 'bg2' => '#f5d0fe', 'glyph' => 'lipstick'],
    'electronics' => ['c1' => '#1d4ed8', 'c2' => '#06b6d4', 'c3' => '#172554', 'bg1' => '#eff6ff', 'bg2' => '#cffafe', 'glyph' => 'headphone'],
    'jewelry' => ['c1' => '#a16207', 'c2' => '#fcd34d', 'c3' => '#292524', 'bg1' => '#fffbeb', 'bg2' => '#fde68a', 'glyph' => 'ring'],
    'furniture' => ['c1' => '#8b5e34', 'c2' => '#a3b18a', 'c3' => '#4a3421', 'bg1' => '#faf6ef', 'bg2' => '#e7dccf', 'glyph' => 'sofa'],
    'healthcare' => ['c1' => '#0284c7', 'c2' => '#5eead4', 'c3' => '#075985', 'bg1' => '#f0f9ff', 'bg2' => '#cffafe', 'glyph' => 'cross'],
    'education' => ['c1' => '#4f46e5', 'c2' => '#7dd3fc', 'c3' => '#3730a3', 'bg1' => '#eef2ff', 'bg2' => '#ddd6fe', 'glyph' => 'cap'],
    'travel' => ['c1' => '#0e7490', 'c2' => '#f97316', 'c3' => '#164e63', 'bg1' => '#ecfeff', 'bg2' => '#bae6fd', 'glyph' => 'plane'],
];

// simple recognizable industry glyphs (SVG path, 100x100 viewBox space)
$GLYPH = [
    'jar' => 'M30 18h40v8a6 6 0 0 1-2 4.5V78a8 8 0 0 1-8 8H40a8 8 0 0 1-8-8V30.5A6 6 0 0 1 30 26zM36 44h28v14H36z',
    'plate' => 'M20 50a30 30 0 1 1 60 0a30 30 0 1 1-60 0M32 50a18 18 0 1 1 36 0a18 18 0 1 1-36 0',
    'shirt' => 'M38 14l12 8 12-8 16 10-8 14-6-4v40H30V34l-6 4-8-14z',
    'lipstick' => 'M42 14h16v22H42zM38 36h24v12H38zM40 48h20v38H40z',
    'headphone' => 'M20 58a30 26 0 0 1 60 0v10h-8V58a22 18 0 0 0-44 0v10h-8zM20 60h8a4 4 0 0 1 4 4v14a4 4 0 0 1-4 4h-8zM72 60h8a4 4 0 0 1 4 4v14a4 4 0 0 1-4 4h-8z',
    'ring' => 'M50 82a22 22 0 1 1 0-44 22 22 0 0 1 0 44zM42 26l8-10 8 10-8 8z',
    'sofa' => 'M18 56a10 10 0 0 1 10-10h44a10 10 0 0 1 10 10v8H18zM26 40h20v6H26zM54 40h20v6H54zM14 64h72v14a4 4 0 0 1-4 4H18a4 4 0 0 1-4-4z',
    'cross' => 'M42 14h16v28h28v16H58v28H42V58H14V42h28z',
    'cap' => 'M20 46a30 22 0 0 1 60 0v4H20zM14 50h72v8H14zM50 24v22',
    'plane' => 'M56 12l10 6-14 26 20 24-6 8-22-18-16 14-6-6 14-16-18-22 8-6 20 16z',
];

function svgHero(array $g, string $glyph, int $n): string {
    $angle = [15, 115, 205, 305][$n % 4];
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{$g['bg1']}"/><stop offset="1" stop-color="{$g['bg2']}"/>
    </linearGradient>
    <linearGradient id="ac" gradientTransform="rotate($angle .5 .5)">
      <stop offset="0" stop-color="{$g['c1']}"/><stop offset="1" stop-color="{$g['c2']}"/>
    </linearGradient>
    <radialGradient id="glow" cx=".7" cy=".2" r=".9">
      <stop offset="0" stop-color="{$g['c2']}" stop-opacity=".55"/><stop offset="1" stop-color="{$g['c2']}" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <rect width="800" height="600" fill="url(#bg)"/>
  <circle cx="640" cy="90" r="260" fill="url(#glow)"/>
  <circle cx="110" cy="520" r="180" fill="{$g['c1']}" opacity=".12"/>
  <circle cx="690" cy="430" r="90" fill="{$g['c2']}" opacity=".2"/>
  <circle cx="230" cy="120" r="46" fill="{$g['c2']}" opacity=".3"/>
  <g transform="translate(300 150) scale(2)" fill="url(#ac)" opacity=".95">
    <path d="$glyph"/>
  </g>
  <rect x="240" y="470" width="320" height="10" rx="5" fill="{$g['c1']}" opacity=".35"/>
  <rect x="300" y="492" width="200" height="8" rx="4" fill="{$g['c1']}" opacity=".2"/>
</svg>
SVG;
}

function svgProduct(array $g, string $glyph, int $n): string {
    $angle = [45, 160, 260, 320, 20, 200][$n % 6];
    $rot = [-8, 6, -5, 7, -7, 5][$n % 6];
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="{$g['bg1']}"/><stop offset="1" stop-color="{$g['bg2']}"/>
    </linearGradient>
    <linearGradient id="ac" gradientTransform="rotate($angle .5 .5)">
      <stop offset="0" stop-color="{$g['c1']}"/><stop offset="1" stop-color="{$g['c2']}"/>
    </linearGradient>
  </defs>
  <rect width="800" height="800" fill="url(#bg)"/>
  <circle cx="640" cy="140" r="140" fill="{$g['c2']}" opacity=".25"/>
  <circle cx="150" cy="660" r="110" fill="{$g['c1']}" opacity=".14"/>
  <ellipse cx="400" cy="640" rx="240" ry="34" fill="{$g['c3']}" opacity=".16"/>
  <g transform="translate(180 170) rotate($rot 220 220) scale(4.2)" fill="url(#ac)">
    <path d="$glyph"/>
  </g>
  <g fill="{$g['c2']}">
    <circle cx="120" cy="130" r="7"/><circle cx="690" cy="560" r="9"/><circle cx="660" cy="660" r="5"/>
  </g>
</svg>
SVG;
}

function svgAvatar(array $g, string $glyph, int $n): string {
    $angle = [30, 120, 210, 300, 75][$n % 5];
    return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
  <defs>
    <linearGradient id="bg" gradientTransform="rotate($angle .5 .5)">
      <stop offset="0" stop-color="{$g['c1']}"/><stop offset="1" stop-color="{$g['c3']}"/>
    </linearGradient>
    <clipPath id="rc"><circle cx="100" cy="100" r="100"/></clipPath>
  </defs>
  <g clip-path="url(#rc)">
    <rect width="200" height="200" fill="url(#bg)"/>
    <circle cx="160" cy="40" r="60" fill="#ffffff" opacity=".14"/>
    <circle cx="100" cy="86" r="30" fill="#ffffff" opacity=".9"/>
    <path d="M50 170a50 42 0 0 1 100 0z" fill="#ffffff" opacity=".9"/>
  </g>
</svg>
SVG;
}

$count = 0;
foreach ($G as $key => $g) {
    $dir = __DIR__ . "/public/assets/img/genres/$key";
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $gl = $GLYPH[$g['glyph']];
    for ($i = 1; $i <= 4; $i++) {
        file_put_contents("$dir/hero-$i.svg", svgHero($g, $gl, $i)); $count++;
    }
    for ($i = 1; $i <= 6; $i++) {
        file_put_contents("$dir/product-$i.svg", svgProduct($g, $gl, $i)); $count++;
    }
    for ($i = 1; $i <= 5; $i++) {
        file_put_contents("$dir/avatar-$i.svg", svgAvatar($g, $gl, $i)); $count++;
    }
    echo "$key: 15 files\n";
}
echo "TOTAL: $count SVGs\n";
