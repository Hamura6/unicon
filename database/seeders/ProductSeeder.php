<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'nombre'=>'12X43X130',
            'caracteristicas'=>'12X43X130',
            'precio'=>24,
            'stock'=>100,
            'categoria'=>'Plastaformo'
        ]);
        Product::create([
            'nombre'=>'12X60X130',
            'precio'=>33.46,
            'stock'=>100,
            'categoria'=>'Plastaformo',
            'caracteristicas'=>'12X60X130',
        ]);


        Product::create([
            'nombre'=>'15X43X130',
            'caracteristicas'=>'15X43X130',
            'precio'=>24,
            'stock'=>100,
            'categoria'=>'Plastaformo'
        ]);
        Product::create([
            'nombre'=>'15X60X130',
            'precio'=>35,
            'stock'=>100,
            'categoria'=>'Plastaformo',
            'caracteristicas'=>'15X60X130',
        ]);


        Product::create([
            'nombre'=>'12X40X130',
            'caracteristicas'=>'12X40X130',
            'precio'=>20,
            'stock'=>100,
            'categoria'=>'Plastaformo'
        ]);
        Product::create([
            'nombre'=>'15X40X130',
            'precio'=>30.46,
            'stock'=>100,
            'categoria'=>'Plastaformo',
            'caracteristicas'=>'15X40X130',
        ]);



        Product::create([
            'nombre'=>'VP 2',
            'precio'=>24.6,
            'stock'=>1000,
            'descripcion'=>'4  2X2.25',
            'caracteristicas'=>'1.00-4.30',
            'categoria'=>'Vigueta',
        ]);
        Product::create([
            'nombre'=>'VP 4',
            'precio'=>26.32,
            'stock'=>1000,
            'descripcion'=>'5  2X2.25',
            'caracteristicas'=>'4.30-4.80',
            'categoria'=>'Vigueta',
        ]);
        Product::create([
            'nombre'=>'VP 6',
            'precio'=>29.99,
            'stock'=>1000,
            'descripcion'=>'4  2X2.25, 2 3X2.25',
            'caracteristicas'=>'4.90-5.60',
            'categoria'=>'Vigueta',
        ]);
        Product::create([
            'nombre'=>'VP 7',
            'precio'=>34.8,
            'stock'=>1000,
            'descripcion'=>'1 2X2.25, 5 2X2.25',
            'caracteristicas'=>'5.70-6.00',
            'categoria'=>'Vigueta',
        ]);
        Product::create([
            'nombre'=>'VP 8',
            'precio'=>44.2,
            'stock'=>1000,
            'descripcion'=>'2 3X2.25, 3 3X3.00',
            'caracteristicas'=>'6.10-7.40',
            'categoria'=>'Vigueta',
        ]);
    }
}
