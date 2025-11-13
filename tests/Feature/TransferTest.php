<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_transferencia_valida_funciona()
{
    $fromUser = User::factory()->create();
    $toUser = User::factory()->create();

    $asset1 = Asset::factory()->create([
        'valor_contabil' => 1000,
        'current_user_id' => $fromUser->id,
    ]);

    $asset2 = Asset::factory()->create([
        'valor_contabil' => 1000,
        'current_user_id' => $toUser->id,
    ]);

    $this->actingAs($fromUser);

    $response = $this->postJson('/api/transferencia', [
        'from_user_id' => $fromUser->id,
        'to_user_id' => $toUser->id,
        'from_assets' => [$asset1->id],
        'to_assets' => [$asset2->id],
    ]);

    $response->assertStatus(200);
}

}
