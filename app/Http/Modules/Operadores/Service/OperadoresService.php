<?php

namespace App\Http\Modules\Operadores\Service;
use App\Http\Modules\Operadores\Model\Operadores;


class OperadoresService
{
    public function crearOperador(array $data)
    {
        return Operadores::create($data);
    }

    public function listarOperadores()
    {
        return Operadores::with(['user', 'entidad', 'cargo'])->get();
    }

    public function mostrarOperadorPorId($id)
    {
        return Operadores::with(['user', 'entidad', 'cargo'])->findOrFail($id);
    }

    public function actualizarOperador($id, array $data)
    {
        $operador = Operadores::findOrFail($id);
        $operador->update($data);
        return $operador;
    }

    public function eliminarOperadorPorId($id)
    {
        $operador = Operadores::findOrFail($id);
        $operador->delete();
        return true;
    }
}
