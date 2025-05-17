<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Services\AddressService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_registra_usuario_com_endereco_valido()
    {
        $mockAddressService = Mockery::mock(AddressService::class);
        $mockAddressService->shouldReceive('getAddressFromCep')
            ->with('01001000')
            ->once()
            ->andReturn([
                'street' => 'Praça da Sé',
                'neighborhood' => 'Sé',
                'city' => 'São Paulo',
                'state' => 'SP',
            ]);

        $userService = new UserService($mockAddressService);

        $user = $userService->register([
            'name' => 'Usuário Teste',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'cep' => '01001000',
            'number' => '123',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'teste@example.com']);
        $this->assertEquals('São Paulo', $user->city);
    }

    public function test_retorna_null_para_cep_invalido()
    {
        $mockAddressService = Mockery::mock(AddressService::class);
        $mockAddressService->shouldReceive('getAddressFromCep')
            ->with('99999999')
            ->once()
            ->andReturn(null);

        $userService = new UserService($mockAddressService);

        $user = $userService->register([
            'name' => 'Teste Falso',
            'email' => 'fail@example.com',
            'password' => 'senha123',
            'cep' => '99999999',
            'number' => '456',
        ]);

        $this->assertNull($user);
        $this->assertDatabaseMissing('users', ['email' => 'fail@example.com']);
    }
}
