<?php

namespace App\Http\Modules\Cargos\Request;

use Illuminate\Foundation\Http\FormRequest;

class CrearCargoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:cargos,nombre',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cargo es obligatorio.',
            'nombre.unique' => 'Ya existe un cargo con ese nombre.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
        ];
    }
}
