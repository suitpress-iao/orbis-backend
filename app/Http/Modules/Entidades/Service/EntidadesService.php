<?php

namespace App\Http\Modules\Entidades\Service;

use App\Http\Modules\Entidades\Model\Entidades;

class EntidadesService
{
    public function crearEntidad(array $data)
    {
        return Entidades::create($data);
    }

    public function listarEntidades()
    {
        return Entidades::get();
    }

    public function mostrarEntidadPorId($id)
    {
        return Entidades::findOrFail($id);
    }

    public function actualizarEntidad($id, array $data)
    {
        $entidad = Entidades::findOrFail($id);
        $entidad->update($data);
        return $entidad;
    }

    public function eliminarEntidadPorId($id)
    {
        $entidad = Entidades::findOrFail($id);
        $entidad->delete();
        return true;
    }
}
