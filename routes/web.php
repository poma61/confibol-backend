<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/storage-link', function () {
    // Ejecutar el comando de enlace simbólico
Artisan::call('storage:link');
    
    return 'Enlace simbólico creado correctamente';
});

Route::get('/migrate', function () {
    // Ejecutar el comando de enlace simbólico
Artisan::call('migrate');
    
    return 'migrate ok';
});

Route::get('/db-seed', function () {
    // Ejecutar el comando de enlace simbólico
Artisan::call('db:seed');
    
    return 'db seed OK';
});

