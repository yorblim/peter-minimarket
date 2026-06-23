<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement([
                'Lácteos',
                'Carnes',
                'Frutas y Verduras',
                'Abarrotes',
                'Bebidas',
                'Limpieza',
                'Panadería',
                'Snacks',
                'Condimentos',
                'Cuidado Personal',
            ]),
        ];
    }
}
