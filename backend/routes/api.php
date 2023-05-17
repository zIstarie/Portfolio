<?php

use Portfolio\Src\Controllers\EmpregadoController;
use Portfolio\Src\Controllers\IdiomaController;

$apiRoutes = [
    '/empregado' => [
        'GET' => EmpregadoController::class . '@retrieve',
        'POST' => EmpregadoController::class . '@store',
        'PUT' => EmpregadoController::class . '@update',
        'PATCH' => EmpregadoController::class . '@update',
        'DELETE' => EmpregadoController::class . '@destroy'
    ],
    '/idiomas' => [
        'GET' => IdiomaController::class . '@retrieve',
        'POST' => IdiomaController::class . '@store',
        'PUT' => IdiomaController::class . '@update',
        'PATCH' => IdiomaController::class . '@update',
        'DELETE' => IdiomaController::class . '@destroy'
    ]
];

?>