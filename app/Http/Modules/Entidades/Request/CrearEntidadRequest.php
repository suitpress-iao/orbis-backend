<?php

namespace App\Http\Modules\Entidades\Request;

use Illuminate\Foundation\Http\FormRequest;

class CrearEntidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
           'nombre' => 'required|string|max:100|unique:entidades,nombre', 
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la entidad es obligatorio.',
            'nombre.unique' => 'Ya existe una entidad con ese nombre.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
        ];
    }
}
