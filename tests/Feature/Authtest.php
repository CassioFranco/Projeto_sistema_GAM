<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Authtest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_and_login()
    {
        $response = $this->postJson('/api/registro', [
            'name' => 'Test',
            'email' => 't@t.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'age' => 25,
            'latitude' => -23.55,
            'longitude' => -46.63
        ]);
        $response->assertStatus(201);

        $login = $this->postJson('/api/acesso', ['email' => 't@t.com', 'password' => 'secret123']);
        $login->assertStatus(200)->assertJsonStructure(['token', 'user']);
    }

}
