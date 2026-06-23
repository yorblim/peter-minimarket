<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Este seeder está deshabilitado — los productos se cargan en ProductoCategoriaSeeder

        $abarroteId  = Categoria::where('nombre', 'Abarrotes')->value('id');
        $bebidasId   = Categoria::where('nombre', 'Bebidas')->value('id');
        $limpiezaId  = Categoria::where('nombre', 'Limpieza')->value('id');
        $lacteosId   = Categoria::where('nombre', 'Lácteos')->value('id');

        $productos = [
            [
                'nombre'        => 'Aceite Vegetal Primor 1L',
                'marca'         => 'PRIMOR',
                'precio'        => 9.90,
                'precio_oferta' => null,
                'stock'         => 20,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/2753230-450-450/232431.jpg',
                'categoria_id'  => $abarroteId,
            ],
            [
                'nombre'        => 'Leche Evaporada Entera 400g',
                'marca'         => 'GLORIA',
                'precio'        => 4.50,
                'precio_oferta' => 4.10,
                'stock'         => 50,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/511394-450-450/210255.jpg',
                'categoria_id'  => $lacteosId,
            ],
            [
                'nombre'        => 'Arroz Extra Superior x 5Kg',
                'marca'         => 'COSTEÑO',
                'precio'        => 18.50,
                'precio_oferta' => null,
                'stock'         => 15,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/2436792-450-450/93012.jpg',
                'categoria_id'  => $abarroteId,
            ],
            [
                'nombre'        => 'Gaseosa Coca-Cola Original 2L',
                'marca'         => 'COCA-COLA',
                'precio'        => 7.20,
                'precio_oferta' => 6.50,
                'stock'         => 30,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/2428612-450-450/594301.jpg',
                'categoria_id'  => $bebidasId,
            ],
            [
                'nombre'        => 'Detergente en Polvo Bolsa 800g',
                'marca'         => 'ACE',
                'precio'        => 12.90,
                'precio_oferta' => null,
                'stock'         => 10,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/2443478-450-450/356341.jpg',
                'categoria_id'  => $limpiezaId,
            ],
            [
                'nombre'        => 'Fideos Spaghetti x 500g',
                'marca'         => 'DON VITTORIO',
                'precio'        => 3.80,
                'precio_oferta' => 3.20,
                'stock'         => 40,
                'imagen'        => 'https://plazavea.vteximg.com.br/arquivos/ids/2733981-450-450/54823.jpg',
                'categoria_id'  => $abarroteId,
            ],
        ];

        foreach ($productos as $data) {
            Producto::create($data);
        }

        $this->command->info('6 productos de prueba con imágenes externas creados.');
    }
}
