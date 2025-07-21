<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/lib/config.php";

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');

$basePath = "";

if ($basePath && str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath));
}

if ($path === "") {
    $path = "index";
}

$file = __DIR__ . "/pages/" . $path . ".php";

if (file_exists($file)) {
    require_once $file;
} else {
    http_response_code(404);
    echo "Page not found";
}