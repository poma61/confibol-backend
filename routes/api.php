<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login']);


Route::prefix('/auth')->middleware(['jwt'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/verify-role', [AuthController::class, 'isRole']); //para verificar el roles
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
    Route::post('/by-ci-personal', [PersonalController::class, 'recordByCi']);
});

Route::prefix('/usuario')->middleware(['jwt', 'role:administrador'])->group(function () {
    Route::post('/all-data', [UsuarioController::class, 'index']);
    Route::post('/new-data', [UsuarioController::class, 'store']);
    Route::put('/edit-data', [UsuarioController::class, 'update']);
    Route::post('/delete-data', [UsuarioController::class, 'destroy']);
});
