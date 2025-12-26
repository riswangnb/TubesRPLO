<?php
echo "<h2>1. Isi Folder API (Tempat file ini berada):</h2>";
$files_api = scandir(__DIR__);
echo "<pre>" . print_r($files_api, true) . "</pre>";

echo "<h2>2. Isi Folder Root (Satu level di atas):</h2>";
$files_root = scandir(__DIR__ . '/../');
echo "<pre>" . print_r($files_root, true) . "</pre>";

echo "<h2>3. Cek Folder Public:</h2>";
if (is_dir(__DIR__ . '/../public')) {
    echo "Folder 'public' DITEMUKAN. Isinya:<br>";
    $files_public = scandir(__DIR__ . '/../public');
    echo "<pre>" . print_r($files_public, true) . "</pre>";
} else {
    echo "Folder 'public' TIDAK DITEMUKAN di root.";
}
?>