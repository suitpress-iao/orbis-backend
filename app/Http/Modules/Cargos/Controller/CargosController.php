<?php

namespace App\Http\Modules\Cargos\Controller;
use App\Http\Controllers\Controller;
use App\Http\Modules\Cargos\Service\CargosService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CargosController extends Controller
{
    public function __construct(private CargosService $cargosService)
    {}

    public function crearCargo(Request $request): JsonResponse
    {
        try {

            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
            ]);

            $cargo = $this->cargosService->crearCargo($validated);
            return response()->json($cargo, 201);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al crear cargo'], 500);
        }
    }

    public function listarCargos(): JsonResponse
    {
        try{
            $cargos = $this->cargosService->listarCargos();
            return response()->json($cargos, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al listar los cargos'], 500);
        }
    }

    public function mostrarCargoPorId($id): JsonResponse
    {
        try {
            $cargo = $this->cargosService->mostrarCargoPorId($id);

            return response()->json($cargo, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cargo no encontrado'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al mostrar el cargo'], 500);
        }
    }

    public function actualizarCargo(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|String|max:255',
            ]);
            $cargo = $this->cargosService->actualizarCargo($id, $validated);

            return response()->json($cargo, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cargo no encontrado'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al actualizar el cargo'], 500);
        }
    }

    public function eliminarCargoPorId($id): JsonResponse
    {
        try {
            $this->cargosService->eliminarCargoPorId($id);
            return response()->json([
                'mensaje' => 'Cargo eliminado correctamente',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cargo no encontrado'], 404);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Error al eliminar el cargo'], 500);
        }
    }
}
