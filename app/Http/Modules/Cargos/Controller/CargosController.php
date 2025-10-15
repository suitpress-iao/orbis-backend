<?php

namespace App\Http\Modules\Cargos\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Cargos\Service\CargosService;
use Illuminate\Http\Request;

class CargosController extends Controller
{
    public function __construct(private CargosService $cargosService)
    {}

    public function crearCargo(Request $data): \Illuminate\Http\JsonResponse
    {
        try {
            $cargo = $this->cargosService->crearCargo($data->all());
            return response()->json($cargo, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
