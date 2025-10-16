<?php

namespace App\Http\Modules\Entidades\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Entidades\Service\EntidadesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EntidadesController extends Controller
{
    public function __construct(private EntidadesService $entidadesService)
    {}

    public function crearEntidad(Request $data)
    {
        try {
            $entidad = $this->entidadesService->crearEntidad($data->all());
            return response()->json($entidad, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function listarEntidades()
    {
        try{
            $entidades = $this->entidadesService->listarEntidades();
            return response()->json($entidades, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function mostrarEntidad($id)
    {
        try{
            $entidad = $this->entidadesService->obtenerEntidad($id);

            return response()->json($entidad, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function actualizarEntidad(Request $request, $id)
    {
        try {
            $entidad = $this->entidadesService->actualizarEntidad($id, $request->all());

            return response()->json($entidad, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al obtener la entidad',
                'detalle' => $th->getMessage(),
            ], 500);
        }
    }

    public function eliminarEntidad($id)
    {
        try{
            $this->entidadesService->eliminarEntidad($id);

            return response()->json([
                'mensaje' => 'Entidad eliminada correctamente',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al obtener la entidad',
                'detalle' => $th->getMessage(),
            ], 500);
        }
    }
}
