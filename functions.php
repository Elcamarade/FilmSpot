<?php

function readJSON($path) {
    $full = __DIR__ . '/../' . $path; 
    
    if (!file_exists($full)) {
        return [];
    }
    
    return json_decode(file_get_contents($full), true) ?? [];
}

function saveJSON($path, $data) {
    $full = __DIR__ . '/../' . $path;
    $dir = dirname($full);

    if (!is_dir($dir)) {

        mkdir($dir, 0777, true);
    }
    file_put_contents($full, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}