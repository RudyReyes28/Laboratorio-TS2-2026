<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [ 'codigo' => 'P001', 'nombre' => 'Laptop HP', 'descripcion' => 'Laptop HP Pavilion 15', 'precio' => 1200.00, 'stock' => 10, 'categoria_id' => 1, 'activo' => true],
            [ 'codigo' => 'P002', 'nombre' => 'Smartphone Samsung', 'descripcion' => 'Samsung Galaxy S21', 'precio' => 800.00, 'stock' => 20, 'categoria_id' => 1, 'activo' => true],
            [ 'codigo' => 'P003', 'nombre' => 'Tablet Apple', 'descripcion' => 'iPad Pro 11"', 'precio' => 999.00, 'stock' => 15, 'categoria_id' => 1, 'activo' => true],
            [ 'codigo' => 'P004', 'nombre' => 'Monitor LG', 'descripcion' => 'LG UltraFine 27"', 'precio' => 500.00, 'stock' => 8, 'categoria_id' => 2, 'activo' => true],
            [ 'codigo' => 'P005', 'nombre' => 'Teclado Logitech', 'descripcion' => 'Logitech MX Keys', 'precio' => 100.00, 'stock' => 25, 'categoria_id' => 2, 'activo' => true],
        ];

        DB::table('productos')->insert($productos);
    }
}
