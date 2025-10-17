<?php

namespace App\Http\Modules\Operadores\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Operadores\Service\OperadoresService;
use Illuminate\Http\Request;

class OperadoresController extends Controller
{
    public function __construct(private OperadoresService $operadoresService)
    {}

    public function crearOperador(Request $request)
    {
        try{
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'entidad_id' => 'required|integer|exists:entidades,id',
                'cargo_id' => 'required|integer|exists:cargos,id',
            ]);
            $operador = $this->operadoresService->crearOperador($validated);
            return response()->json($operador, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al crear el operador'
            ], 500);
        }
    }

    public function listarOperadores()
    {
        try {
            $operadores = $this->operadoresService->listarOperadores();
            return response()->json($operadores);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al listar operadores',
            ], 500);
        }
    }

    public function mostrarOperadorPorId($id)
    {
        try {
            $operador = $this->operadoresService->mostrarOperadorPorId($id);
            return response()->json($operador);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al mostrar el operador',
            ], 404);
        }
    }

    public function actualizarOperador(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'integer|exists:users,id',
                'entidad_id' => 'integer|exists:entidades,id',
                'cargo_id' => 'integer|exists:cargos,id',
            ]);

            $operador = $this->operadoresService->actualizarOperador($id, $validated);
            return response()->json($operador);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al actualizar el operador',
            ], 500);
        }
    }

    public function eliminarOperadorPorId($id)
    {
        try {
            $this->operadoresService->eliminarOperadorPorId($id);
            return response()->json(['mensaje' => 'Operador eliminado correctamente']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al eliminar el operador',
            ], 500);
        }
    }
}
