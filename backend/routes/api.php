<?php

use Portfolio\Src\Controllers\EmpregadoController;

$apiRoutes = [
    '/empregado' => [
        'GET' => EmpregadoController::class . '@retrieve',
        'POST' => EmpregadoController::class . '@store',
        'PUT' => EmpregadoController::class . '@update',
        'PATCH' => EmpregadoController::class . '@update',
        'DELETE' => EmpregadoController::class . '@destroy'
    ],
];

?>