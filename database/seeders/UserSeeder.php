<?php

namespace Database\Seeders;

use App\Http\Modules\Operadores\Model\Operadores;
use App\Models\User;
use App\Models\Operador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario desarrollador
        $user = User::updateOrCreate(
            ['email' => 'admin@miapp.com'],
            [
                'password' => Hash::make('password123'),
                'password_changed_at' => now(),
                'activo' => true,
            ]
        );

        // Asignar rol
        $user->assignRole('desarrollador');

        // Crear operador asociado
        Operadores::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'tipo_documento' => 'CC',
                'documento' => '123456789',
                'telefono' => '3001234567',
                'email_recuperacion' => 'admin@miapp.com',
            ]
        );

        // Crear usuario admin
        $admin = User::updateOrCreate(
            ['email' => 'admin2@miapp.com'],
            [
                'password' => Hash::make('password123'),
                'password_changed_at' => now(),
                'activo' => true,
            ]
        );

        $admin->assignRole('admin');

        Operadores::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'tipo_documento' => 'CC',
                'documento' => '987654321',
                'telefono' => '3009876543',
                'email_recuperacion' => 'admin2@miapp.com',
                'cargo_id' => null,
                'entidad_id' => null,
            ]
        );
    }
}