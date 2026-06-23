<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;
use App\Models\CarritoItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_no_puede_ir_a_checkout_si_compra_es_menor_a_35()
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'nombre' => 'Galletas',
            'precio' => 5,
            'stock' => 10
        ]);

        CarritoItem::create([
            'user_id' => $user->id,
            'producto_id' => $producto->id_producto,
            'cantidad' => 2  // Total = 10
        ]);

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertRedirect('/cart');
    }

    /** @test */
    public function usuario_si_puede_ver_checkout_si_compra_es_mayor_a_35()
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'nombre' => 'Aceite',
            'precio' => 40,
            'stock' => 10
        ]);

        CarritoItem::create([
            'user_id' => $user->id,
            'producto_id' => $producto->id_producto,
            'cantidad' => 1
        ]);

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Resumen de tu compra');
    }

    /** @test */
    public function delivery_es_gratis_si_total_es_mayor_a_45()
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'nombre' => 'Arroz Costeño',
            'precio' => 50,
            'stock' => 10
        ]);

        CarritoItem::create([
            'user_id' => $user->id,
            'producto_id' => $producto->id_producto,
            'cantidad' => 1
        ]);

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('GRATIS');
    }

    /** @test */
    public function al_pagar_se_vacia_el_carrito()
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'nombre' => 'Leche Gloria',
            'precio' => 40,
            'stock' => 10
        ]);

        CarritoItem::create([
            'user_id' => $user->id,
            'producto_id' => $producto->id_producto,
            'cantidad' => 1
        ]);

        $this->actingAs($user)->post('/checkout/process', [
            'nombre' => 'Cliente Test',
            'tarjeta' => '1234567812345678',
            'vencimiento' => '2030-12',
            'cvv' => '123'
        ]);

        $this->assertDatabaseMissing('carrito_items', [
            'user_id' => $user->id
        ]);
    }
}
