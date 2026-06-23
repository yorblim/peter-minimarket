<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function se_puede_registrar_un_producto()
    {
        $producto = Producto::create([
            'nombre' => 'Laptop HP',
            'descripcion' => 'Laptop 16GB RAM',
            'precio' => 2500.00,
            'stock' => 5,
            'imagen' => 'hp.jpg',
        ]);

        $this->assertDatabaseHas('productos', ['nombre' => 'Laptop HP']);
    }

    /** @test */
    public function se_puede_listar_productos()
    {
        Producto::factory()->count(3)->create();

        $response = $this->get('/productos');
        $response->assertStatus(200);
    }
}
