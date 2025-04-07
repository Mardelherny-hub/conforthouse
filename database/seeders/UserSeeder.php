<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
            ]
        );
        $admin->syncRoles('admin');

        // Usuario AGENTE
        $agente = User::firstOrCreate(
            ['email' => 'agente@inmobiliaria.com'],
            [
                'name' => 'Agente Pérez',
                'password' => Hash::make('12345678'),
            ]
        );
        $agente->syncRoles('agente');

        // Usuario CLIENTE (por si lo necesitás más adelante)
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@inmobiliaria.com'],
            [
                'name' => 'Cliente Gómez',
                'password' => Hash::make('12345678'),
            ]
        );
        $cliente->syncRoles('cliente');
    }
}
