<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);

        User::create([
            'name' => 'Empleado',
            'email' => 'empleado@example.com',
            'password' => Hash::make('empleado123'),
            'rol' => 'empleado',
        ]);

        User::create([
            'name' => 'Trabajador (legacy)',
            'email' => 'worker@example.com',
            'password' => Hash::make('worker123'),
            'rol' => 'empleado',
        ]);

        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'password' => Hash::make('cliente123'),
            'rol' => 'cliente',
        ]);
    }
}
