<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarritoIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function crearUsuario()
    {
        return User::factory()->create([
            'rol' => 'cliente'
        ]);
    }

    protected function crearProducto()
    {
        return Producto::create([
            'nombre' => 'Galletas Oreo',
            'precio' => 5,
            'stock' => 20,
        ]);
    }

    /** @test */
    public function usuario_puede_agregar_producto_al_carrito()
    {
        $user = $this->crearUsuario();
        $producto = $this->crearProducto();

        $response = $this->actingAs($user)
                         ->post('/cart/add/' . $producto->id_producto);

        $response->assertRedirect(); 
    }

    /** @test */
    public function usuario_puede_ver_el_carrito()
    {
        $user = $this->crearUsuario();

        $response = $this->actingAs($user)->get('/cart');

        $response->assertStatus(200);
        $response->assertSee('Carrito');
    }

    /** @test */
    public function producto_se_muestra_en_el_carrito()
    {
        $user = $this->crearUsuario();
        $producto = $this->crearProducto();

        $this->actingAs($user)->post('/cart/add/' . $producto->id_producto);

        $response = $this->actingAs($user)->get('/cart');

        $response->assertSee('Galletas Oreo');
        $response->assertSee('5.00');
    }
}
