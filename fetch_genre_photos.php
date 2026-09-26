<?php
// Download real, freely-licensed photos for every industry image slot.
// Sources: Wikimedia Commons (bitmap search, free licenses) + randomuser.me portraits.
// Fallback: if a slot fails, the existing genre SVG stays and the resolver uses it.

$GENRES = [
    'organic' => ['hero' => 'spice market india', 'items' => ['mango pickle jar', 'honey jar', 'ghee jar', 'lemon pickle', 'date palm jaggery', 'pickled vegetables']],
    'restaurant' => ['hero' => 'bangladeshi food dishes', 'items' => ['biryani plate', 'khichuri', 'tehari', 'firni dessert', 'lassi drink glass', 'buffet food table']],
    'fashion' => ['hero' => 'saree fashion model', 'items' => ['panjabi kurta', 'jamdani saree', 'kurti woman', 'plain t-shirt', 'silk fabric', 'embroidery clothing']],
    'beauty' => ['hero' => 'cosmetics products flatlay', 'items' => ['face serum bottle', 'sunscreen bottle', 'matte lipstick', 'hair oil bottle', 'face wash tube', 'perfume bottle']],
    'electronics' => ['hero' => 'gadgets flatlay', 'items' => ['wireless headphones', 'smartwatch', 'power bank', 'usb type c cable', 'bluetooth speaker', 'wireless earbuds case']],
    'jewelry' => ['hero' => 'gold jewelry', 'items' => 'gold necklace, silver bangles, pearl earrings, bridal jewellery set, handmade bracelet, oxidised necklace',
    ],
    'furniture' => ['hero' => 'wooden furniture interior', 'items' => ['wooden dining chair', 'sofa living room', 'study table desk', 'bookshelf', 'bedside table', 'wall shelf wood']],
    'healthcare' => ['hero' => 'pharmacy shelves', 'items' => ['vitamin tablets bottle', 'digital thermometer', 'blood pressure monitor', 'baby care kit', 'surgical mask', 'hand sanitizer bottle']],
    'education' => ['hero' => 'classroom students studying', 'items' => ['english grammar books', 'graphic design workspace', 'exam preparation students', 'online class laptop', 'graduation cap certificate', 'coaching class room']],
    'travel' => ['hero' => "cox's bazar beach", 'items' => ['sajek valley', 'kuala lumpur skyline', 'dubai skyline', 'honeymoon resort pool', 'group travel friends', 'airplane wing sunset']],
];
// normalize jewelry items (string above)
$GENRES['jewelry']['items'] = ['gold necklace', 'silver bangles', 'pearl earrings', 'bridal jewellery set', 'handmade bracelet', 'oxidised necklace'];

function apiGet(string $url): ?array
{
    $ctx = stream_context_create(['http' => ['timeout' => 25, 'header' => "User-Agent: AcharBariDemoBuilder/1.0\r\n"]]);
    $raw = @file_get_contents($url, false, $ctx);
    if ($raw === false) return null;
    return json_decode($raw, true);
}

function commonsPhotos(string $query, int $limit = 6): array
{
    $url = 'https://commons.wikimedia.org/w/api.php?' . http_build_query([
        'action' => 'query', 'format' => 'json',
        'generator' => 'search',
        'gsrsearch' => 'filetype:bitmap ' . $query,
        'gsrnamespace' => 6, 'gsrlimit' => 10,
        'prop' => 'imageinfo', 'iiprop' => 'url|size|mime',
        'iiurlwidth' => 1280,
    ]);
    $data = apiGet($url);
    $out = [];
    foreach (($data['query']['pages'] ?? []) as $page) {
        $info = $page['imageinfo'][0] ?? null;
        if (!$info) continue;
        $mime = $info['mime'] ?? '';
        if (!in_array($mime, ['image/jpeg', 'image/png'], true)) continue;
        if (($info['width'] ?? 0) < 700 || ($info['height'] ?? 0) < 450) continue;
        $out[] = ['url' => $info['thumburl'] ?? $info['url'], 'page' => $page['title'] ?? '', 'w' => $info['width'], 'h' => $info['height']];
        if (count($out) >= $limit) break;
    }
    return $out;
}

function saveImage(string $url, string $dest): bool
{
    $ctx = stream_context_create(['http' => ['timeout' => 40, 'header' => "User-Agent: AcharBariDemoBuilder/1.0\r\n"]]);
    $bytes = @file_get_contents($url, false, $ctx);
    if ($bytes === false || strlen($bytes) < 12000) return false;
    $info = @getimagesizefromstring($bytes);
    if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) return false;
    if ($info[0] < 500 || $info[1] < 350) return false;

    // normalize to real jpeg via GD when possible (png/webp with transparency would break as .jpg)
    if (function_exists('imagecreatefromstring')) {
        $img = @imagecreatefromstring($bytes);
        if ($img) {
            ob_start();
            imagejpeg($img, null, 82);
            $jpg = ob_get_clean();
            if (strlen($jpg) > 10000) $bytes = $jpg;
            imagedestroy($img);
        }
    }
    file_put_contents($dest, $bytes);
    return true;
}

$base = __DIR__ . '/public/assets/img/genres';
$avatarIdx = 11;
$credits = "# Industry photo credits\n\nAll photos are freely-licensed (Wikimedia Commons) or used from randomuser.me mock portraits.\n\n";

foreach ($GENRES as $genre => $cfg) {
    $dir = "$base/$genre";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $line = "## $genre\n";

    // hero-1/2 from hero keyword; hero-3/4 from first product queries
    $heroResults = commonsPhotos($cfg['hero'], 4);
    usleep(300000);
    if (isset($heroResults[0])) { saveImage($heroResults[0]['url'], "$dir/hero-1.jpg"); $line .= "- hero-1.jpg: {$heroResults[0]['page']}\n"; }
    if (isset($heroResults[1])) { saveImage($heroResults[1]['url'], "$dir/hero-2.jpg"); $line .= "- hero-2.jpg: {$heroResults[1]['page']}\n"; }

    $i = 0;
    foreach ($cfg['items'] as $kw) {
        $i++;
        $res = commonsPhotos($kw, 3);
        usleep(250000);
        foreach ($res as $r) {
            if (saveImage($r['url'], "$dir/product-$i.jpg")) { $line .= "- product-$i.jpg: {$r['page']}\n"; break; }
        }
        if ($i <= 2) {
            $hs = "$dir/hero-" . ($i + 2) . ".jpg";
            if (!is_file($hs) && isset($res[0])) {
                if (saveImage($res[0]['url'], $hs)) $line .= "- hero-" . ($i + 2) . ".jpg: {$res[0]['page']}\n";
            }
        }
    }

    // avatars (real mock portraits)
    for ($a = 1; $a <= 5; $a++) {
        $sex = ($a % 2) ? 'men' : 'women';
        $idx = $avatarIdx + $a * 7;
        $bytes = @file_get_contents("https://randomuser.me/api/portraits/$sex/$idx.jpg");
        if ($bytes && strlen($bytes) > 3000) file_put_contents("$dir/avatar-$a.jpg", $bytes);
    }
    $avatarIdx += 3;

    $count = count(glob("$dir/*.jpg"));
    echo str_pad($genre, 12), "$count jpg photos\n";
    $credits .= $line . "\n";
}

file_put_contents(__DIR__ . '/public/assets/img/genres/CREDITS.md', $credits);
echo "DONE\n";
