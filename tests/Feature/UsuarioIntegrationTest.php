<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_registrarse()
    {
        $response = $this->post('/register', [
            'name' => 'Edison',
            'email' => 'edison@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', ['email' => 'edison@example.com']);
    }

    /** @test */
    public function usuario_puede_iniciar_sesion()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }
}
