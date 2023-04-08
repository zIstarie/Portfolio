<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

if (!str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
    http_response_code(404);

    echo json_encode([
        'message' => 'Invalid URI'
    ]);

    die();
}

$endpoint = explode('/api', $_SERVER['REQUEST_URI'])[1];

?>
