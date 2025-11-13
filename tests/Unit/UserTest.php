<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_usuario_deve_ter_email_valido()
    {
        $user = new User(['email' => 'invalido']);
        $this->assertFalse(filter_var($user->email, FILTER_VALIDATE_EMAIL) !== false);
    }

    public function test_usuario_possui_localizacao_valida()
    {
        $user = new User(['latitude' => -45.1234567, 'longitude' => -22.9876543]);
        $this->assertTrue(
            $user->latitude >= -90 && $user->latitude <= 90 &&
            $user->longitude >= -180 && $user->longitude <= 180,
            'Latitude ou longitude fora do intervalo válido'
        );
    }
}
