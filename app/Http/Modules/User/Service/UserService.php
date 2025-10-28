<?php

namespace App\Http\Modules\User\Service;

use App\Http\Modules\User\Models\User;
use App\Http\Modules\Operadores\Model\Operadores;
use App\Http\Modules\Entidades\Model\Entidades;
use App\Http\Modules\Cargos\Model\Cargos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserService
{
    public function crearUsuario(array $data)
    {
        return DB::transaction(function () use ($data){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);


            if (
                isset($data['entidad_id'], $data['cargo_id']) &&
                Entidades::find($data['entidad_id']) &&
                Cargos::find($data['cargo_id'])
                ) {
                Operadores::create([
                    'user_id' => $user->id,
                    'entidad_id' => $data['entidad_id'],
                    'cargo_id' => $data['cargo_id'],
                 ]);



                return $user->load('operadores');
            }

            return $user;
        });
    }

    public function login(array $data): array
    {
        if (
            !Auth::attempt([
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
