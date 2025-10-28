<?php

use App\Http\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json('pong', 200);
});

// Route::post('/register', [UserController::class, 'crearUsuario'])->name('crearUsuario');
// Route::post('/login', [UserController::class, 'login'])->name('login');


// Rutas públicas
Route::prefix('auth')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
});

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
    });

    // // Usuarios (con permisos)
    // Route::prefix('usuarios')->group(function () {
    //     Route::get('/', [UsuarioController::class, 'index'])
    //         ->middleware('permission:usuarios.vista');
        
    //     Route::post('/', [UsuarioController::class, 'store'])
    //         ->middleware('permission:usuarios.crear');
        
    //     Route::get('/{id}', [UsuarioController::class, 'show'])
    //         ->middleware('permission:usuarios.vista');
        
    //     Route::put('/{id}', [UsuarioController::class, 'update'])
    //         ->middleware('permission:usuarios.editar');
        
    //     Route::delete('/{id}', [UsuarioController::class, 'destroy'])
    //         ->middleware('permission:usuarios.eliminar');
        
    //     Route::post('/{id}/assign-role', [UsuarioController::class, 'assignRole'])
    //         ->middleware('permission:usuarios.asignarRol');
        
    //     Route::post('/{id}/assign-permission', [UsuarioController::class, 'assignPermission'])
    //         ->middleware('permission:usuarios.asignarPermisos');
    // });

    // // Roles
    // Route::prefix('roles')->group(function () {
    //     Route::get('/', [RoleController::class, 'index'])
    //         ->middleware('permission:roles.vista');
        
    //     Route::post('/', [RoleController::class, 'store'])
    //         ->middleware('permission:roles.crear');
        
    //     Route::put('/{id}', [RoleController::class, 'update'])
    //         ->middleware('permission:roles.editar');
        
    //     Route::delete('/{id}', [RoleController::class, 'destroy'])
    //         ->middleware('permission:roles.eliminar');
    // });
});







Route::middleware('auth:api')->group(function () {

    require __DIR__ . '/cargos/cargos.php';
    require __DIR__ . '/entidades/entidades.php';
    require __DIR__ . '/operadores/operadores.php';

});

Route::get('/login', function () {
    return response()->json('token not implemented yet');
});