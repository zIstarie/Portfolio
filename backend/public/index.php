<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

$prefixIsNotValid = !str_starts_with($_SERVER['REQUEST_URI'], '/api');
$isNotRootPath = $_SERVER['REQUEST_URI'] !== '/';

if ($prefixIsNotValid AND $isNotRootPath) {
    http_response_code(404);

    echo json_encode([
        'message' => 'Invalid URI'
    ]);

    die();
}

$endpoint = explode('/api', $_SERVER['REQUEST_URI'])[1];

?>
