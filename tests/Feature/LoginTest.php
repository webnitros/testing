<?php

namespace Tests\Feature;

use AppTesting\OrderPlacedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function authenticate()
    {

        app('dispatcher')->addListener('order.placed', function (OrderPlacedEvent $event) {
            // will be executed when the acme.foo.action event is dispatched
            return $event->getOrder();
        });


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
