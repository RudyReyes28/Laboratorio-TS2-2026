<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categorias = [
            ['nombre' => 'Electrónica', 'descripcion' => 'Dispositivos electrónicos y gadgets.'],
            ['nombre' => 'Ropa', 'descripcion' => 'Prendas de vestir para todas las edades.'],
            ['nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar y decoración.'],
            ['nombre' => 'Juguetes', 'descripcion' => 'Juguetes para niños de todas las edades.'],
            ['nombre' => 'Deportes', 'descripcion' => 'Equipamiento y ropa deportiva.'],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
