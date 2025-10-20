<?php

namespace App\Http\Modules\User\Service;

use App\Http\Modules\User\Models\User;
use App\Http\Modules\Operadores\Model\Operadores;
use App\Http\Modules\Entidades\Model\Entidades;
use App\Http\Modules\Cargos\Model\Cargos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function crearUsuario(array $data)
    {
        /* $data['password'] = Hash::make($data['password']);
        return User::create($data); */

        // Crear usuario y operador de forma transaccional para evitar registros huérfanos
        return DB::transaction(function () use ($data){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            //para crear el operador debo verificar que existan los datos de entidad y cargo
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

                
                 //retornar toda la informacion sin tener que mirar todos los modelos 
                return $user->load('operadores');
            }

            return $user;
        });
    }

    public function login(array $data)
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
}