<?php

namespace App\Http\Modules\Cargos\Request;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarCargoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:cargos,nombre,' . $this->route('id')
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cargo es obligatorio.',
            'nombre.string'   => 'El nombre del cargo debe ser texto.',
            'nombre.max'      => 'El nombre del cargo no debe exceder 100 caracteres.',
            'nombre.unique'   => 'Ya existe un cargo con este nombre.',
        ];
    }
}
