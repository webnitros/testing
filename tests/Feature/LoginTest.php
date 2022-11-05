<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function authenticate()
    {
        $this->postJson('/api/login', [
            'email' => 'info@bustep.ru',
            'password' => 'password',
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['token', 'expires_in'])
            ->assertJson(['token_type' => 'bearer']);
    }

    /** @test */
    public function log_out()
    {
        $token = $this->postJson('/api/login', [
            'email' => 'info@bustep.ru',
            'password' => 'password',
        ])->json()['token'];

        $this->postJson("/api/logout?token=$token")
            ->assertSuccessful();

        $this->getJson("/api/user?token=$token")
            ->assertStatus(401);
    }
}
