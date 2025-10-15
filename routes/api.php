<?php

use App\Http\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json('pong', 200);
});

Route::post('/register', [UserController::class, 'crearUsuario'])->name('crearUsuario');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::middleware('auth:api')->group(function () {

    require __DIR__ . '/cargos/cargos.php';
    require __DIR__ . '/operadores/operadores.php'; 

});

Route::get('/login', function () {
    return response()->json('token not implemented yet');
});