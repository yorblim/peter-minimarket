<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Producto;


class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'rol' => 'admin'
        ]);
    }

    /**
     * Probar que la ruta /productos carga correctamente.
     */
    public function test_pagina_productos_se_carga_correctamente()
    {
        $user = $this->admin();

        $response = $this->actingAs($user)->get('/productos');

        $response->assertStatus(200);
        $response->assertSee('Lista de Productos');
    }

    /**
     * Probar que la lista de productos simulados aparece.
     */
    public function test_lista_de_productos_se_muestra()
{
    $user = $this->admin();

    Producto::create([
        'nombre' => 'Televisor Smart 55"',
        'precio' => 1500,
        'stock' => 10
    ]);

    Producto::create([
        'nombre' => 'Celular Samsung Galaxy',
        'precio' => 999,
        'stock' => 20
    ]);

    Producto::create([
        'nombre' => 'Laptop Lenovo i5',
        'precio' => 2300,
        'stock' => 5
    ]);

    $response = $this->actingAs($user)->get('/productos');

    $response->assertSee('Televisor Smart 55"');
    $response->assertSee('Celular Samsung Galaxy');
    $response->assertSee('Laptop Lenovo i5');
}

    /**
     * Probar que se muestra el precio formateado.
     */
    public function test_precios_se_muestran_con_formato()
    {
        $user = $this->admin();

        Producto::create([
            'nombre' => 'Televisor Smart 55"',
            'precio' => 1500,
            'stock' => 10
        ]);

        Producto::create([
            'nombre' => 'Celular Samsung Galaxy',
            'precio' => 999,
            'stock' => 20
        ]);

        Producto::create([
            'nombre' => 'Laptop Lenovo i5',
            'precio' => 2300,
            'stock' => 5
        ]);

        $response = $this->actingAs($user)->get('/productos');

        $response->assertSee('S/ 1,500.00');
        $response->assertSee('S/ 999.00');
        $response->assertSee('S/ 2,300.00');
    }

}
