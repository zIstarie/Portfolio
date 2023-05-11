<?php


require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

use Portfolio\Config\Dotenv;

define('DOTENV', Dotenv::config());

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

$params = explode('/', $endpoint)[count(explode('/', $endpoint)) - 1];
$params && $endpoint = '/' . explode('/', $endpoint)[1];

foreach ($apiRoutes as $key => $route) {
    if ($key !== $endpoint) continue;

    $class = explode('@', $route[$method]);
    $controller = new $class[0];

    if (
        $method === 'POST' AND
        str_contains($_SERVER['CONTENT_TYPE'], 'multipart/form-data')
    ) {
        move_uploaded_file($_FILES['url-imagem']['tmp_name'], __DIR__ . '/assets/' . $_FILES['url-imagem']['name']);

        http_response_code(200);
        echo json_encode([
            'message' => 'File Processed',
            'status' => http_response_code()
        ]);

        die();
    }

    $FILES = $REQUEST['url-imagem'];
    $FILES['full_path'] = __DIR__ . '/assets/' . $REQUEST['url-imagem']['name'];

    match ($method) {
        'GET' => $controller->{$class[1]}(),
        'POST' => $controller->{$class[1]}($REQUEST, $FILES),
        'PUT', 'PATCH' => $controller->{$class[1]}($params, $REQUEST),
        'DELETE' => $controller->{$class[1]}($params),
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
