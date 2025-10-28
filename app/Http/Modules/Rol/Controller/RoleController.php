<?php

namespace App\Http\Modules\Rol\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Rol\Service\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function crearRol(Request $request)
    {
        try {
            $rol = $this->roleService->crearRol($request->all());
            return response()->json(['data' => $rol], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al crear el rol', 'message' => $th->getMessage()], 500);
        }
    }

    public function listarRoles()
    {
        try {
            $rol = $this->roleService->obtenerTodosRoles();
            return response()->json(['data' => $rol], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener los roles', 'message' => $th->getMessage()], 500);
        }
    }

    public function editarRol(Request $request, $id)
    {
        try {
            $rol = $this->roleService->editarRol($id, $request->all());
            return response()->json(['data' => $rol], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al editar el rol', 'message' => $th->getMessage()], 500);
        }
    }

    public function eliminarRol($id)
    {
        try {
            $this->roleService->eliminarRol($id);
            return response()->json(['message' => 'Rol eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar el rol', 'message' => $th->getMessage()], 500);
        }
    }
}