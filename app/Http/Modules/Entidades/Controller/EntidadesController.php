<?php

namespace App\Http\Modules\Entidades\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Entidades\Service\EntidadesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;


class EntidadesController extends Controller
{
    public function __construct(private EntidadesService $entidadesService)
    {}

    public function crearEntidad(Request $request): JsonResponse
    {
        try {
            /* agregare un validador para garantizar el tipo de dato ingresado */
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
            ]);

            $entidad = $this->entidadesService->crearEntidad($validated);
            return response()->json($entidad, 201);
        } catch (Throwable $th) {
            return response()->json([
                'error' => 'Error al crear la entidad',
                'detalle' => $th->getMessage()
            ], 500);
        }
    }

    public function listarEntidades(): JsonResponse
    {
        try{
            $entidades = $this->entidadesService->listarEntidades();
            return response()->json($entidades, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al listar entidades'], 500);
        }
    }

    public function mostrarEntidadPorId($id): JsonResponse
    {
        try{
            $entidad = $this->entidadesService->mostrarEntidadPorId($id);

            return response()->json($entidad, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Entidad no encontrada'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al obtener la entidad'], 500);
        }
    }

    public function actualizarEntidad(Request $request, $id): JsonResponse
    {
        try {

            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $entidad = $this->entidadesService->actualizarEntidad($id, $validated);

            return response()->json($entidad, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Entidad no encontrada'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al actualizar la entidad'], 500);
        }
    }

    public function eliminarEntidadPorId($id): JsonResponse
    {
        try{
            $this->entidadesService->eliminarEntidadPorId($id);

            return response()->json([
                'mensaje' => 'Entidad eliminada correctamente',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Entidad no encontrada'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al eliminar la entidad'], 500);
        }
    }
}
