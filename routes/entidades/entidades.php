<?php


use Illuminate\Support\Facades\Route;
use App\Http\Modules\Entidades\Controller\EntidadesController;

Route::prefix('entidades')->group(function () {
    Route::post('/', [EntidadesController::class, 'crearEntidad']);
    Route::get('/', [EntidadesController::class, 'listarEntidades']);
    Route::get('/{id}', [EntidadesController::class, 'mostrarEntidad']);
    Route::put('/{id}', [EntidadesController::class, 'actualizarEntidad']);
    Route::delete('/{id}', [EntidadesController::class, 'eliminarEntidad']);
});
