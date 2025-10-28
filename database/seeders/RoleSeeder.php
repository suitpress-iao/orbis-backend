<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear rol de Desarrollador con todos los permisos
        $desarrollador = Role::updateOrCreate(
            ['name' => 'desarrollador'],
            [
                'guard_name' => 'api',
                'descripcion' => 'Rol con todos los permisos del sistema'
            ]
        );

        // Asignar todos los permisos al desarrollador
        $permisos = Permission::all();
        $desarrollador->syncPermissions($permisos);

        // Crear rol de Admin
        $admin = Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'guard_name' => 'api',
                'descripcion' => 'Administrador del sistema'
            ]
        );

        $admin->givePermissionTo([
            'menu.inicio',
            'admin.enter',
            'usuarios.vista',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.asignarRol',
            'roles.vista',
            'roles.crear',
            'roles.editar',
        ]);

        // Crear rol de Usuario
        $usuario = Role::updateOrCreate(
            ['name' => 'usuario'],
            [
                'guard_name' => 'api',
                'descripcion' => 'Usuario estándar del sistema'
            ]
        );

        $usuario->givePermissionTo([
            'menu.inicio',
            'menu.piezasInformativas',
            'menu.manualesVideos',
        ]);
    }
}