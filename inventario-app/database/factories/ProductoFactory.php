<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => strtoupper($this->faker->unique()->bothify('PROD-?###?')),
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence(10),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'categoria_id'=> Categoria::inRandomOrder()->first()->id, // Asumiendo que hay 5 categorías en la base de datos
            'activo' => $this->faker->boolean(80),
        ];
    }
}
