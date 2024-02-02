<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\DepositoController;
use App\Http\Controllers\Api\GrupoController;
use App\Http\Controllers\Api\LoteProductoController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::prefix('/auth')->middleware(['jwt'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/actualizar-credenciales', [AuthController::class, 'updateCredentials']);
});

Route::prefix('/security-frontend')->middleware(['jwt'])->group(function () {
    Route::post('/verify-role', [AuthController::class, 'isRole']); //para verificar el roles
});


Route::prefix('/personal')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [PersonalController::class, 'index']);
    Route::post('/new-data', [PersonalController::class, 'store']);
    Route::put('/edit-data', [PersonalController::class, 'update']);
    Route::post('/delete-data', [PersonalController::class, 'destroy']);
    Route::post('/buscar-personal-por-ci', [PersonalController::class, 'recordByCi']);
});

Route::prefix('/role')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/listar', [RoleController::class, 'list']);
});
Route::prefix('/usuario')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [UsuarioController::class, 'index']);
    Route::post('/new-data', [UsuarioController::class, 'store']);
    Route::put('/edit-data', [UsuarioController::class, 'update']);
    Route::post('/delete-data', [UsuarioController::class, 'destroy']);
});

Route::prefix('/deposito')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/listar', [DepositoController::class, 'list']);
    Route::post('/all-data', [DepositoController::class, 'index']);
    Route::post('/new-data', [DepositoController::class, 'store']);
    Route::put('/edit-data', [DepositoController::class, 'update']);
    Route::post('/delete-data', [DepositoController::class, 'destroy']);
});


Route::prefix('/compra')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [CompraController::class, 'index']);
    Route::post('/new-data', [CompraController::class, 'store']);
    Route::put('/edit-data', [CompraController::class, 'update']);
    Route::post('/delete-data', [CompraController::class, 'destroy']);
});

Route::prefix('/producto')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/listar', [ProductoController::class, 'list']);
    Route::post('/all-data', [ProductoController::class, 'index']);
    Route::post('/new-data', [ProductoController::class, 'store']);
    Route::put('/edit-data', [ProductoController::class, 'update']);
    Route::post('/delete-data', [ProductoController::class, 'destroy']);
});

Route::prefix('/lote-producto')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [LoteProductoController::class, 'index']);
    Route::post('/new-data', [LoteProductoController::class, 'store']);
    Route::put('/edit-data', [LoteProductoController::class, 'update']);
    Route::post('/delete-data', [LoteProductoController::class, 'destroy']);
});

Route::prefix('/grupo')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/listar', [GrupoController::class, 'list']);
    Route::post('/all-data', [GrupoController::class, 'index']);
    Route::post('/new-data', [GrupoController::class, 'store']);
    Route::put('/edit-data', [GrupoController::class, 'update']);
    Route::post('/delete-data', [GrupoController::class, 'destroy']);
});

Route::prefix('/cliente')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [ClienteController::class, 'index']);
    Route::post('/new-data', [ClienteController::class, 'store']);
    Route::put('/edit-data', [ClienteController::class, 'update']);
    Route::post('/delete-data', [ClienteController::class, 'destroy']);
});


