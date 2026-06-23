<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    private static array $productos = [
        ['nombre' => 'Leche Evaporada Entera 400g',       'marca' => 'Gloria',       'precio' => 4.50,  'categoria' => 'Lácteos'],
        ['nombre' => 'Yogurt Natural Batido 1L',           'marca' => 'Gloria',       'precio' => 8.90,  'categoria' => 'Lácteos'],
        ['nombre' => 'Queso Fresco x 300g',                'marca' => 'Don Jorge',    'precio' => 12.50, 'categoria' => 'Lácteos'],
        ['nombre' => 'Mantequilla x 200g',                 'marca' => 'Laive',        'precio' => 9.20,  'categoria' => 'Lácteos'],
        ['nombre' => 'Pechuga de Pollo x Kg',              'marca' => 'San Fernando', 'precio' => 14.90, 'categoria' => 'Carnes'],
        ['nombre' => 'Carne Molida Especial x Kg',         'marca' => 'San Fernando', 'precio' => 22.50, 'categoria' => 'Carnes'],
        ['nombre' => 'Chuletas de Cerdo x Kg',             'marca' => 'San Fernando', 'precio' => 18.90, 'categoria' => 'Carnes'],
        ['nombre' => 'Pollo Entero x Kg',                  'marca' => 'San Fernando', 'precio' => 11.50, 'categoria' => 'Carnes'],
        ['nombre' => 'Manzana Israel x Kg',                'marca' => null,           'precio' => 5.80,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Plátano de Seda x Kg',               'marca' => null,           'precio' => 3.20,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Papaya x Unidad',                    'marca' => null,           'precio' => 6.50,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Cebolla Roja x Kg',                  'marca' => null,           'precio' => 2.80,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Tomate Italiano x Kg',               'marca' => null,           'precio' => 3.50,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Papa Amarilla x Kg',                 'marca' => null,           'precio' => 2.20,  'categoria' => 'Frutas y Verduras'],
        ['nombre' => 'Arroz Extra Superior x 5Kg',         'marca' => 'Costeño',      'precio' => 18.50, 'categoria' => 'Abarrotes'],
        ['nombre' => 'Aceite Vegetal x 1L',                'marca' => 'Primor',       'precio' => 9.90,  'categoria' => 'Abarrotes'],
        ['nombre' => 'Azúcar Rubia x 5Kg',                 'marca' => 'Cartavio',     'precio' => 16.20, 'categoria' => 'Abarrotes'],
        ['nombre' => 'Fideos Spaghetti x 500g',            'marca' => 'Don Vittorio', 'precio' => 3.80,  'categoria' => 'Abarrotes'],
        ['nombre' => 'Lentejas x 500g',                    'marca' => 'Costeño',      'precio' => 4.20,  'categoria' => 'Abarrotes'],
        ['nombre' => 'Atún en Lomito x 160g',              'marca' => 'Florida',      'precio' => 6.90,  'categoria' => 'Abarrotes'],
        ['nombre' => 'Gaseosa Coca-Cola 2L',               'marca' => 'Coca-Cola',    'precio' => 8.50,  'categoria' => 'Bebidas'],
        ['nombre' => 'Agua Mineral Sin Gas 2L',            'marca' => 'San Luis',     'precio' => 3.50,  'categoria' => 'Bebidas'],
        ['nombre' => 'Cerveza Cusqueña Botella 620ml',     'marca' => 'Cusqueña',     'precio' => 7.90,  'categoria' => 'Bebidas'],
        ['nombre' => 'Jugo de Naranja Natural 1L',         'marca' => 'Cifrut',       'precio' => 6.50,  'categoria' => 'Bebidas'],
        ['nombre' => 'Lejía x 1L',                         'marca' => 'Patito',       'precio' => 4.30,  'categoria' => 'Limpieza'],
        ['nombre' => 'Detergente Bolsa 800g',              'marca' => 'Ace',          'precio' => 12.90, 'categoria' => 'Limpieza'],
        ['nombre' => 'Lavavajillas Limón x 500ml',         'marca' => 'Ayudín',       'precio' => 8.20,  'categoria' => 'Limpieza'],
        ['nombre' => 'Desinfectante Aromático x 1L',       'marca' => 'Sapolio',      'precio' => 9.50,  'categoria' => 'Limpieza'],
    ];

    public function definition(): array
    {
        $data = fake()->randomElement(self::$productos);

        return [
            'nombre'        => $data['nombre'],
            'marca'         => $data['marca'],
            'precio'        => $data['precio'],
            'precio_oferta' => null,
            'stock'         => fake()->numberBetween(5, 100),
            'descripcion'   => fake()->sentence(),
            'imagen'        => null,
        ];
    }

    public function enOferta(): static
    {
        return $this->state(fn (array $attributes) => [
            'precio_oferta' => round($attributes['precio'] * fake()->randomFloat(1, 0.7, 0.9), 2),
        ]);
    }
}
