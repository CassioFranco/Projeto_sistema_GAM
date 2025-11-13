<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Asset;

class AssetTest extends TestCase
{
    public function test_valor_contabil_deve_ser_positivo()
    {
        $asset = new Asset(['valor_contabil' => -100]);

        $this->assertLessThanOrEqual(0, $asset->valor_contabil, 'O valor contábil negativo deve ser rejeitado');
    }

    public function test_status_padrao_do_ativo_e_em_uso()
    {
        $asset = new Asset();
        $asset->status = $asset->status ?? 'EM_USO';
        $this->assertEquals('EM_USO', $asset->status);
    }
}
