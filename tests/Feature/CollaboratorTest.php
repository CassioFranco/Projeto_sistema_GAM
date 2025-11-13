<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollaboratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_atualizacao_de_localizacao_registra_historico()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->patchJson("/api/colaboradores/{$user->id}/localizacao", [
            'latitude' => -23.45,
            'longitude' => -46.65
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('locations', ['user_id' => $user->id]);
    }
}
