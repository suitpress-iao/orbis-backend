<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Menú
            ['name' => 'menu.inicio', 'descripcion' => 'Ver menú de inicio'],
            ['name' => 'menu.piezasInformativas', 'descripcion' => 'Ver piezas informativas'],
            ['name' => 'menu.manualesVideos', 'descripcion' => 'Ver manuales y videos'],
            
            // Admin
            ['name' => 'admin.enter', 'descripcion' => 'Acceder al menú de administración'],
            
            // Usuarios
            ['name' => 'usuarios.vista', 'descripcion' => 'Ver lista de usuarios'],
            ['name' => 'usuarios.crear', 'descripcion' => 'Crear usuarios'],
            ['name' => 'usuarios.editar', 'descripcion' => 'Editar usuarios'],
            ['name' => 'usuarios.eliminar', 'descripcion' => 'Eliminar usuarios'],
            ['name' => 'usuarios.asignarRol', 'descripcion' => 'Asignar roles a usuarios'],
            ['name' => 'usuarios.asignarPermisos', 'descripcion' => 'Asignar permisos directos a usuarios'],
            
            // Roles
            ['name' => 'roles.vista', 'descripcion' => 'Ver lista de roles'],
            ['name' => 'roles.crear', 'descripcion' => 'Crear roles'],
            ['name' => 'roles.editar', 'descripcion' => 'Editar roles'],
            ['name' => 'roles.eliminar', 'descripcion' => 'Eliminar roles'],
            
            // Agendamiento
            ['name' => 'agendamiento.medico', 'descripcion' => 'Ver menú de agendamiento'],
            ['name' => 'agendamiento.medico.vista', 'descripcion' => 'Ver agendamiento médico'],
            ['name' => 'agendamiento.medico.programacion', 'descripcion' => 'Programar agendas'],
            
            // Reportes
            ['name' => 'reportes.vista', 'descripcion' => 'Ver reportes'],
            ['name' => 'reportes.exportar', 'descripcion' => 'Exportar reportes'],
            ['name' => 'reportes.ventas', 'descripcion' => 'Ver reporte de ventas'],
            ['name' => 'reportes.inventario', 'descripcion' => 'Ver reporte de inventario'],
            
            // Facturación
            ['name' => 'facturacion.vista', 'descripcion' => 'Ver facturación'],
            ['name' => 'facturacion.crear', 'descripcion' => 'Crear facturas'],
            ['name' => 'facturacion.aprobar', 'descripcion' => 'Aprobar facturas'],
            ['name' => 'facturacion.anular', 'descripcion' => 'Anular facturas'],
            
            // Superadmin
            ['name' => 'superadmin.actions', 'descripcion' => 'Acciones de superadministrador'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'guard_name' => 'api',
                    'descripcion' => $permission['descripcion'],
                ]
            );
        }
    }
}
