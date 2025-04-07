<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Lista de permisos agrupados por módulo
        $permissions = [
            // Propiedades
            'crear propiedades',
            'editar propiedades',
            'eliminar propiedades',
            'ver propiedades',

            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Características
            'ver características',
            'crear características',
            'editar características',
            'eliminar características',

            // Traducciones
            'ver traducciones',
            'editar traducciones',

            // Solicitudes / Contactos
            'ver solicitudes',
            'responder solicitudes',
            'eliminar solicitudes',

            // Clientes
            'gestionar clientes',
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',

            // caracteristicas
            'gestionar características',
            'ver características',
            'crear características',
            'editar características',
            'eliminar características',

            // Usuarios
            'gestionar usuarios',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
        ];

        // Crear los permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $agente = Role::firstOrCreate(['name' => 'agente']);
        $cliente = Role::firstOrCreate(['name' => 'cliente']); // sin permisos por ahora

        // Asignar permisos al rol admin
        $admin->syncPermissions(Permission::all());

        // Asignar permisos específicos al agente
        $agente->syncPermissions([
            'ver propiedades',
            'ver solicitudes',
            'ver clientes',
        ]);

        // Cliente: sin permisos por el momento
    }
}
