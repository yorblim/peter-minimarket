<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_agregar_producto_al_carrito()
    {
        // Crear producto falso
        $producto = Producto::factory()->create([
            'nombre' => 'Laptop Gamer',
            'precio' => 3500.00,
        ]);

        // Hacer POST al carrito
        $response = $this->post(route('cart.add', $producto->id_producto));

        // Verificar redirección
        $response->assertRedirect();

        // Verificar que el producto esté en la sesión
        $this->assertEquals(
            session('cart')[$producto->id_producto]['nombre'],
            'Laptop Gamer'
        );
    }

    /** @test */
    public function puede_eliminar_producto_del_carrito()
    {
        // Crear producto y agregarlo al carrito manualmente
        $producto = Producto::factory()->create();
        session(['cart' => [
            $producto->id_producto => [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
            ],
        ]]);

        // Hacer DELETE
        $response = $this->delete(route('cart.remove', $producto->id_producto));

        // Verificar redirección
        $response->assertRedirect();

        // Verificar que el carrito esté vacío
        $this->assertEmpty(session('cart'));
    }

    /** @test */
    public function muestra_la_vista_del_carrito()
    {
        $response = $this->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
    }
}
