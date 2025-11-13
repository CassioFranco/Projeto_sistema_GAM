<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registro_de_usuario_funciona()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => '123456',
            'idade' => 30,
            'latitude' => -23.5,
            'longitude' => -46.6,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'joao@example.com']);
    }

    public function test_login_funciona()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);

        $response->assertStatus(200);
    }
}
