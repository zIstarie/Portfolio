<?php

use Portfolio\Config\Dotenv;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

const DOTENV = Dotenv::config();

$prefixIsNotValid = !str_starts_with($_SERVER['REQUEST_URI'], '/api');
$isNotRootPath = $_SERVER['REQUEST_URI'] !== '/';

if ($prefixIsNotValid AND $isNotRootPath) {
    http_response_code(404);

    echo json_encode([
        'message' => 'Invalid URI'
    ]);

    die();
}

$endpoint = explode('/api/' . DOTENV['VERSION'], $_SERVER['REQUEST_URI'])[1];
$method = $_SERVER['REQUEST_METHOD'];
$REQUEST = json_decode(file_get_contents('php://input'), true);

foreach ($apiRoutes as $key => $route) {
    if ($key !== $endpoint) continue;

    $class = explode('@', $route[$method]);
    $controller = new $class[0]();

    if (
        $method === 'POST' AND
        $_SERVER['CONTENT_TYPE'] === 'multipart/form-data'
    ) {
        $_SESSION[basename($class[0])]['FILES'] = $_FILES;
    
        die();
    }

    match ($method) {
        'GET' => $controller->$class[1](),
        'POST' => $controller->$class[1]($REQUEST, $_SESSION[basename($class[0])]['FILES']),
        'PUT' OR 'PATCH' => call_user_func(function () use ($controller, $class, $endpoint, $REQUEST) {
            $params = explode('/', $endpoint)[count(explode('/', $endpoint)) - 1];
            $controller->$class[1]($params, $REQUEST);
        }),
        'DELETE' => call_user_func(function () use ($controller, $class, $endpoint) {
            $params = explode('/', $endpoint)[count(explode('/', $endpoint)) - 1];
            $controller->$class[1]($params);
        }),
        default => call_user_func(function () {
            http_response_code(405);
            echo json_encode([
                'message' => 'Method not specified or not supported',
                'status' => http_response_code()
            ]);
        })
    };
}

?>
