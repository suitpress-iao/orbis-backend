<?php

namespace App\Http\Modules\User\Service;

use App\Http\Modules\Operadores\Model\Operadores;
use App\Http\Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function crearUsuario(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'activo' => true,
            ]);

            Operadores::create([
                'user_id' => $user->id,
                'nombre' => $data['nombre'],
                'apellido' => 'prueba',
                'tipo_documento' => 'CC',
                'documento' => $data['documento'],
                'entidad_id' => $data['entidad_id'] ?? 1,
                'cargo_id' => $data['cargo_id'] ?? 1,
            ]);

            return $user->load('operador');

            return $user;
        });
    }

    public function login(array $data): array
    {
        if (
            ! Auth::attempt([
                'email' => $data['email'] ?? null,
                'password' => $data['password'] ?? null,
            ])
        ) {
            throw new \Exception('Credenciales inválidas', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function assignRole($user, array $roles)
    {
        $user->syncRoles($roles);

        return $user->load('roles');
    }

    public function assignPermission($user, array $permissions)
    {
        $user->syncPermissions($permissions);

        return $user->load('permissions');
    }

    public function assignPermissionToRole($role, array $permissions)
    {
        $role->syncPermissions($permissions);

        return $role->load('permissions');
    }
}
