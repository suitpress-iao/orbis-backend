<?php

use App\Http\Modules\Rol\Controller\RoleController;
use App\Http\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json('pong', 200);
});

// Rutas públicas
Route::prefix('auth')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
});

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
    });

    // Usuarios (con permisos)
    Route::prefix('usuarios')->group(function () {
        Route::post('/{id}/assign-role', [UserController::class, 'assignRole']);
        Route::post('/{id}/assign-permission', [UserController::class, 'assignPermission']);
    });

    // Roles
    Route::prefix('roles')->group(function () {
        Route::get('crear-rol', [RoleController::class, 'crearRol']);
        Route::post('listar-rol', [RoleController::class, 'listarRoles']);
        Route::put('editar-rol/{id}', [RoleController::class, 'editarRol']);
        Route::delete('eliminar-rol/{id}', [RoleController::class, 'eliminarRol']);
    });
});

Route::middleware('auth:api')->group(function () {

    require __DIR__ . '/cargos/cargos.php';
    require __DIR__ . '/entidades/entidades.php';
    require __DIR__ . '/operadores/operadores.php';

});