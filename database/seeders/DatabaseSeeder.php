<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /*  User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
        
        $this->call([RolSeeder::class]);
        $this->call([PermissionSeeder::class]);
        $this->call([ProductSeeder::class]);
        $person=Person::create([
            'nombre'=>'madara',
            'apellido'=>'uchiha',
            'ci'=>'12345678',
            'telefono'=>'76584589',
            'estado'=>'Activo'
        ]);
        $user=$person->user()->create([
            'email'=>'deidaramen2@gmail.com',
            'fecha_n'=>now(),
            'direccion'=>'las lomas',
            'password'=>bcrypt('deidaramen2')
        ]);
        $user->assignRole(1);
    }
}
