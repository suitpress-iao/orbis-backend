<?php

use App\Http\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('usuarios')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/listar-usuarios', 'listarUsuarios');
        Route::put('/modificar-usuario/{id}', 'modificarUsuario');
        Route::delete('/eliminar-usuario/{id}', 'eliminarUsuario');
    });
});
