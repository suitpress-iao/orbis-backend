<?php

use App\Http\Modules\Cargos\Controller\CargosController;
use Illuminate\Support\Facades\Route;

Route::prefix('cargos')->group(function () {
    Route::post('crear-cargo', [CargosController::class, 'crearCargo']);
    Route::get('listar-cargos', [CargosController::class, 'listarCargos']);
    Route::get('mostrar-cargo/{id}', [CargosController::class, 'mostrarCargoPorId']);
    Route::put('modificar-cargo/{id}', [CargosController::class, 'actualizarCargo']);
    Route::delete('eliminar-cargo/{id}', [CargosController::class, 'eliminarCargoPorId']);
});

