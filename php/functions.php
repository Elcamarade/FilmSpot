<?php
function readJSON($path) {
    $fullPath = __DIR__ . '/../' . $path;
    if (!file_exists($fullPath)) return [];
    $content = file_get_contents($fullPath);
    return json_decode($content, true) ?? [];
}

function saveJSON($path, $data) {
    $fullPath = __DIR__ . '/../' . $path;
    $dir = dirname($fullPath);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    file_put_contents($fullPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function findById($array, $id) {
    foreach ($array as $item) {
        if (($item['id'] ?? '') === $id) return $item;
    }
    return null;
}
