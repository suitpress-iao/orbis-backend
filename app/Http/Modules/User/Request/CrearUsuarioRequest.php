<?php

namespace App\Http\Modules\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class CrearUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'entidad_id' => 'nullable|exists:entidades,id',
            'cargo_id' => 'nullable|exists:cargo,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'entidades_id.exists' => 'La entidad seleccionada no existe.',
            'cargo_id.exists' => 'El cargo seleccionado no existe.',
        ];
    }
}
