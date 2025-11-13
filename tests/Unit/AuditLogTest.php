<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\AuditLog;

class AuditLogTest extends TestCase
{
    public function test_auditoria_registra_endpoint_e_metodo()
    {
        $log = new AuditLog([
            'endpoint' => '/api/login',
            'method' => 'POST'
        ]);

        $this->assertNotEmpty($log->endpoint);
        $this->assertContains($log->method, ['GET', 'POST', 'PATCH', 'DELETE']);
    }
}
