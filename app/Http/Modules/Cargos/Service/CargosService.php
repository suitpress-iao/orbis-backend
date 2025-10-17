<?php

namespace App\Http\Modules\Cargos\Service;

use App\Http\Modules\Cargos\Model\Cargos;

class CargosService
{
    public function crearCargo(array $data)
    {
        return Cargos::create($data);
    }

    public function listarCargos()
    {
        return Cargos::get();
    }

    public function mostrarCargoPorId($id)
    {
        return Cargos::findOrFail($id);
    }

    public function actualizarCargo($id, array $data)
    {
        $cargo = Cargos::findOrFail($id);
        $cargo->update($data);
        return $cargo;
    }

    public function eliminarCargoPorId($id)
    {
        $cargo = Cargos::findOrFail($id);
        $cargo->delete();
        return true;
    }
}
