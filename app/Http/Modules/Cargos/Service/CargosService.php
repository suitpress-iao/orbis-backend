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
}
