<?php
/**
 * save_data.php — Helper for saving/updating data in JSON files
 */
require_once __DIR__ . '/functions.php';

function addItem($file, $item) {
    $data = readJSON($file);
    $item['id'] = $item['id'] ?? uniqid();
    $data[] = $item;
    saveJSON($file, $data);
    return $item;
}

function updateItem($file, $id, $updates) {
    $data = readJSON($file);
    foreach ($data as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item = array_merge($item, $updates);
            break;
        }
    }
    saveJSON($file, $data);
}

function deleteItem($file, $id) {
    $data = readJSON($file);
    $data = array_values(array_filter($data, fn($item) => ($item['id'] ?? '') !== $id));
    saveJSON($file, $data);
}
