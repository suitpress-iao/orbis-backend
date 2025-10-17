<?php


use Illuminate\Support\Facades\Route;
use App\Http\Modules\Entidades\Controller\EntidadesController;

Route::prefix('entidades')->group(function () {
    Route::post('crear-entidad/', [EntidadesController::class, 'crearEntidad']);
    Route::get('listar-entidad', [EntidadesController::class, 'listarEntidades']);
    Route::get('mostrar-entidad/{id}', [EntidadesController::class, 'mostrarEntidadPorId']);
    Route::put('modificar-entidad/{id}', [EntidadesController::class, 'actualizarEntidad']);
    Route::delete('eliminar-entidad/{id}', [EntidadesController::class, 'eliminarEntidadPorId']);
});
