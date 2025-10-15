<?php


use App\Http\Modules\Cargos\Controller\CargosController;
use Illuminate\Support\Facades\Route;

Route::prefix('cargos')->group(function () {
    Route::controller(CargosController::class)->group(function () {
        Route::post('/crear-cargo', 'crearCargo');
    });
});
