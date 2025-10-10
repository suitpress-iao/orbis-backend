<?php

namespace App\Http\Modules\User\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\User\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function crearUsuario(Request $request)
    {
        try {
            $usuario = $this->userService->crearUsuario($request->all());
            return response()->json($usuario, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al crear el usuario', 'code' => $th->getCode(), 'mensaje' => $th->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $usuario = $this->userService->login($request->all());
            return response()->json($usuario, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al crear el usuario', 'code' => $th->getCode(), 'mensaje' => $th->getMessage()]);
        }
    }
}
