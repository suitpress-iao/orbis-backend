<?php

namespace App\Http\Modules\Entidades\Request;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarEntidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:entidades,nombre,' . $this->route('id')
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la entidad es obligatorio.',
            'nombre.string'   => 'El nombre de la entidad debe ser texto.',
            'nombre.max'      => 'El nombre de la entidad no debe exceder 100 caracteres.',
            'nombre.unique'   => 'Ya existe una entidad con este nombre.',
        ];
    }
}
