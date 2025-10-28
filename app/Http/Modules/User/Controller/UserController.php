<?php

namespace App\Http\Modules\User\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\User\Service\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {
    }

    /**
     * Login de usuario
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Buscar usuario
            $user = User::where('email', $request->email)
                ->with(['operador.cargo'])
                ->first();

            // Validar credenciales
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales son incorrectas.'],
                ]);
            }

            // Validar que el usuario esté activo
            if (!$user->activo) {
                return response()->json([
                    'message' => 'El usuario no se encuentra activo.'
                ], 403);
            }

            // Crear nuevo token
            $token = $user->createToken('auth-token')->plainTextToken;

            // Obtener permisos usando Spatie
            $permissions = $user->getAllPermissions()->pluck('name');
            $roles = $user->roles->pluck('name');

            // Preparar respuesta
            return response()->json([
                'token_type' => 'Bearer',
                'token' => $token,
                'usuario' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'operador' => $user->operador ? [
                        'nombre_completo' => $user->operador->nombre_completo,
                        'tipo_documento_documento' => $user->operador->tipo_documento_documento,
                        'cargo' => $user->operador->cargo,
                    ] : null,
                    'permissions' => $permissions,
                    'roles' => $roles,
                    'password_changed_at' => $user->password_changed_at,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: 500);
        }
    }

    /**
     * Obtener usuario autenticado
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        // Cargar relaciones
        $user->load(['operador.cargo', 'afiliado']);

        // Obtener permisos
        $permissions = $user->getAllPermissions()->pluck('name');
        $roles = $user->roles->pluck('name');

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'operador' => $user->operador ? [
                'nombre_completo' => $user->operador->nombre_completo,
                'tipo_documento_documento' => $user->operador->tipo_documento_documento,
                'cargo' => $user->operador->cargo,
            ] : null,
            'afiliado' => $user->afiliado ? [
                'nombre_completo' => $user->afiliado->nombre_completo,
            ] : null,
            'permissions' => $permissions,
            'roles' => $roles,
            'password_changed_at' => $user->password_changed_at,
        ], 200);
    }

    /**
     * Logout (cerrar sesión)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Eliminar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'La sesión fue cerrada con éxito.'
        ], 200);
    }

    /**
     * Cambiar contraseña
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual es incorrecta.'
            ], 422);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->new_password),
            'password_changed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Contraseña actualizada exitosamente.'
        ], 200);
    }

    public function assignRole(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user = $this->userService->assignRole($user, $request->roles);

            return response()->json([
                'message' => 'Roles asignados correctamente.',
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: 500);
        }
    }

    public function assignPermission(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user = $this->userService->assignPermission($user, $request->permissions);

            return response()->json([
                'message' => 'Permisos asignados correctamente.',
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: 500);
        }
    }

    public function assignPermissionToRole(Request $request, $roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $role = $this->userService->assignPermissionToRole($role, $request->permissions);

            return response()->json([
                'message' => 'Permisos asignados al rol correctamente.',
                'role' => $role
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: 500);
        }
    }
}
