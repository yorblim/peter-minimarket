<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $categorias = [
            'Lácteos',
            'Carnes',
            'Frutas y Verduras',
            'Abarrotes',
            'Bebidas',
            'Limpieza',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }

        // Mapa: nombre categoría => id
        $catMap = Categoria::pluck('id', 'nombre');

        // Productos de abarrotes
        $productos = [
            // Lácteos
            ['nombre' => 'Leche Evaporada Entera 400g',       'marca' => 'Gloria',       'precio' => 4.50,  'stock' => 50, 'categoria' => 'Lácteos',           'imagen' => 'productos/leche-gloria.jpg'],
            ['nombre' => 'Yogurt Natural Batido 1L',          'marca' => 'Gloria',       'precio' => 8.90,  'stock' => 30, 'categoria' => 'Lácteos',           'imagen' => 'productos/yogurt-gloria.jpg'],
            ['nombre' => 'Queso Fresco x 300g',               'marca' => 'Don Jorge',    'precio' => 12.50, 'stock' => 20, 'categoria' => 'Lácteos',           'imagen' => 'productos/queso-don-jorge.jpg'],
            // Carnes
            ['nombre' => 'Pechuga de Pollo x Kg',             'marca' => 'San Fernando', 'precio' => 14.90, 'stock' => 25, 'categoria' => 'Carnes',            'imagen' => 'productos/pechuga-pollosf.jpg'],
            ['nombre' => 'Carne Molida Especial x Kg',        'marca' => 'San Fernando', 'precio' => 22.50, 'stock' => 15, 'categoria' => 'Carnes',            'imagen' => 'productos/carne-molida-sf.jpg'],
            ['nombre' => 'Chuletas de Cerdo x Kg',            'marca' => 'San Fernando', 'precio' => 18.90, 'stock' => 18, 'categoria' => 'Carnes',            'imagen' => 'productos/chuletas-cerdo-sf.jpg'],
            // Frutas y Verduras
            ['nombre' => 'Manzana Israel x Kg',               'marca' => null,           'precio' => 5.80,  'stock' => 40, 'categoria' => 'Frutas y Verduras', 'imagen' => 'productos/manzana-israel.jpg'],
            ['nombre' => 'Plátano de Seda x Kg',              'marca' => null,           'precio' => 3.20,  'stock' => 60, 'categoria' => 'Frutas y Verduras', 'imagen' => 'productos/platano-seda.jpg'],
            ['nombre' => 'Tomate Italiano x Kg',              'marca' => null,           'precio' => 3.50,  'stock' => 45, 'categoria' => 'Frutas y Verduras', 'imagen' => 'productos/tomate-italiano.jpg'],
            ['nombre' => 'Papa Amarilla x Kg',                'marca' => null,           'precio' => 2.20,  'stock' => 80, 'categoria' => 'Frutas y Verduras', 'imagen' => 'productos/papa-amarilla.jpg'],
            // Abarrotes
            ['nombre' => 'Arroz Extra Superior x 5Kg',        'marca' => 'Costeño',      'precio' => 18.50, 'stock' => 35, 'categoria' => 'Abarrotes',         'imagen' => 'productos/arroz-costeno.jpg'],
            ['nombre' => 'Aceite Vegetal x 1L',               'marca' => 'Primor',       'precio' => 9.90,  'stock' => 28, 'categoria' => 'Abarrotes',         'imagen' => 'productos/aceite-primor.jpg'],
            ['nombre' => 'Azúcar Rubia x 5Kg',                'marca' => 'Cartavio',     'precio' => 16.20, 'stock' => 22, 'categoria' => 'Abarrotes',         'imagen' => 'productos/azucar-cartavio.jpg'],
            ['nombre' => 'Fideos Spaghetti x 500g',           'marca' => 'Don Vittorio', 'precio' => 3.80,  'stock' => 45, 'categoria' => 'Abarrotes',         'imagen' => 'productos/fideos-don-vittorio.jpg'],
            ['nombre' => 'Lentejas x 500g',                   'marca' => 'Costeño',      'precio' => 4.20,  'stock' => 35, 'categoria' => 'Abarrotes',         'imagen' => 'productos/lentejas-costeno.jpg'],
            ['nombre' => 'Atún en Lomito x 160g',             'marca' => 'Florida',      'precio' => 6.90,  'stock' => 40, 'categoria' => 'Abarrotes',         'imagen' => 'productos/atun-florida.jpg'],
            // Bebidas
            ['nombre' => 'Gaseosa Coca-Cola 2L',              'marca' => 'Coca-Cola',    'precio' => 8.50,  'stock' => 50, 'precio_oferta' => 7.20, 'categoria' => 'Bebidas', 'imagen' => 'productos/cocacola.jpg'],
            ['nombre' => 'Agua Mineral Sin Gas 2L',           'marca' => 'San Luis',     'precio' => 3.50,  'stock' => 60, 'categoria' => 'Bebidas',         'imagen' => 'productos/agua-san-luis.jpg'],
            ['nombre' => 'Jugo de Naranja Natural 1L',        'marca' => 'Cifrut',       'precio' => 6.50,  'stock' => 25, 'categoria' => 'Bebidas',         'imagen' => 'productos/jugo-cifrut.jpg'],
            // Limpieza
            ['nombre' => 'Lejía x 1L',                        'marca' => 'Patito',       'precio' => 4.30,  'stock' => 30, 'categoria' => 'Limpieza',         'imagen' => 'productos/lejia-patito.jpg'],
            ['nombre' => 'Detergente Bolsa 800g',             'marca' => 'Ace',          'precio' => 12.90, 'stock' => 20, 'categoria' => 'Limpieza',         'imagen' => 'productos/detergente-ace.jpg'],
            ['nombre' => 'Lavavajillas Limón x 500ml',        'marca' => 'Ayudín',       'precio' => 8.20,  'stock' => 22, 'categoria' => 'Limpieza',         'imagen' => 'productos/lavavajillas-ayudin.jpg'],
            ['nombre' => 'Desinfectante Aromático x 1L',      'marca' => 'Sapolio',      'precio' => 9.50,  'stock' => 18, 'categoria' => 'Limpieza',         'imagen' => 'productos/desinfectante-sapolio.jpg'],
        ];

        foreach ($productos as $data) {
            $catId = $catMap[$data['categoria']] ?? null;

            Producto::create([
                'nombre'        => $data['nombre'],
                'marca'         => $data['marca'],
                'precio'        => $data['precio'],
                'precio_oferta' => $data['precio_oferta'] ?? null,
                'stock'         => $data['stock'],
                'descripcion'   => null,
                'imagen'        => $data['imagen'],
                'categoria_id'  => $catId,
            ]);
        }

        $this->command->info('Categorías y productos de prueba creados.');
    }
}
