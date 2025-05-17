<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_se_registrar_com_dados_validos()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'João Teste',
            'email' => 'joao@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cep' => '01001000',
            'number' => '100',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'joao@example.com']);
    }

    /** @test */
    public function nao_registra_com_cep_invalido()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'João Teste',
            'email' => 'joao2@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'cep' => '99999999',
            'number' => '200',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users', ['email' => 'joao2@example.com']);
    }

    /** @test */
    public function usuario_pode_fazer_login()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('senha123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'senha123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'token']);
    }

    /** @test */
    public function login_falha_com_senha_incorreta()
    {
        $user = User::factory()->create([
            'email' => 'erro@example.com',
            'password' => bcrypt('correta'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'erro@example.com',
            'password' => 'errada',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function usuario_pode_fazer_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logout realizado com sucesso.']);
    }
}
