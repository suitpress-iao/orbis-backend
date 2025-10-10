<?php

namespace App\Http\Modules\User\Service;

use App\Http\Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function crearUsuario(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
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