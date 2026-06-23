<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagoIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_realizar_pago_simulado_con_tarjeta()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/pago/procesar', [
            'nombre' => 'Edison Quispe',
            'numero_tarjeta' => '4111111111111111',
            'fecha_exp' => '12/28',
            'cvv' => '123',
            'monto' => '200.00',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Pago realizado con éxito');
    }
}
