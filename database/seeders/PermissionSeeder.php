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
        Permission::create( [
            'name'=>'Ver usuarios'
        ]);
        Permission::create( [
            'name'=>'Ver permisos'
        ]);
        Permission::create( [
            'name'=>'Asignar permisos'
        ]);
        Permission::create( [
            'name'=>'Ver roles'
        ]);
        Permission::create( [
            'name'=>'Editar rol'
        ]);
        Permission::create( [
            'name'=>'Eliminar rol'
        ]);
        Permission::create( [
            'name'=>'Crear rol'
        ]);
        Permission::create( [
            'name'=>'Ver panel de control'
        ]);

        Permission::create( [
            'name'=>'Actualizar usuario'
        ]);
        Permission::create( [
            'name'=>'Eliminar usuario'
        ]);
        Permission::create( [
            'name'=>'Crear usuario'
        ]);
        


        Permission::create( [
            'name'=>'Ver proveedores'
        ]);
        Permission::create( [
            'name'=>'Crear proveedor'
        ]);
        Permission::create( [
            'name'=>'Editar proveedor'
        ]);
        Permission::create( [
            'name'=>'Eliminar proveedor'
        ]);



        Permission::create( [
            'name'=>'Ver clientes'
        ]);
        Permission::create( [
            'name'=>'Crear cliente'
        ]);
        Permission::create( [
            'name'=>'Editar cliente'
        ]);
        Permission::create( [
            'name'=>'Eliminar cliente'
        ]);




        Permission::create( [
            'name'=>'Ver productos'
        ]);
        Permission::create( [
            'name'=>'Crear producto'
        ]);
        Permission::create( [
            'name'=>'Editar producto'
        ]);
        Permission::create( [
            'name'=>'Eliminar producto'
        ]);



        Permission::create( [
            'name'=>'Ver materiales'
        ]);
        Permission::create( [
            'name'=>'Agregar material'
        ]);
        Permission::create( [
            'name'=>'Editar material'
        ]);
        Permission::create( [
            'name'=>'Eliminar material'
        ]);





        Permission::create( [
            'name'=>'Ver produccion'
        ]);
        Permission::create( [
            'name'=>'Encargado produccion'
        ]);
        Permission::create( [
            'name'=>'Administrar produccion'
        ]);




        Permission::create( [
            'name'=>'Ver reporte de ventas'
        ]);

        Permission::create( [
            'name'=>'Ver repòrte de compras'
        ]);


        Permission::create( [
            'name'=>'Ver reporte de produccion'
        ]);



        Permission::create( [
            'name'=>'Administrar ventas'
        ]);
    }
}
