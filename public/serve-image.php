<?php

// Lấy path từ query string
$path = $_GET['path'] ?? '';

if (empty($path)) {
    http_response_code(400);
    echo 'Missing path parameter';
    exit;
}

// Tạo full path
$fullPath = __DIR__ . '/../storage/app/public/' . $path;

// Kiểm tra file có tồn tại không
if (!file_exists($fullPath)) {
    http_response_code(404);
    echo 'File not found: ' . $path;
    exit;
}

// Lấy MIME type
$mimeType = mime_content_type($fullPath);

// Set headers
header('Content-Type: ' . $mimeType);
header('Cache-Control: public, max-age=31536000');
header('Access-Control-Allow-Origin: *');

// Output file
readfile($fullPath);
