<?php

namespace App\Http\Modules\Rol\Service;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function obtenerTodosRoles()
    {
        return Role::with('permissions')->get();
    }

    public function crearRol(array $data)
    {
        $role = Role::create(['name' => $data['name']]);
        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role->load('permissions');
    }

    public function editarRol(Role $role, array $data)
    {
        $role->update(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role->load('permissions');
    }

    public function eliminarRol(Role $role)
    {
        return $role->delete();
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }
}
