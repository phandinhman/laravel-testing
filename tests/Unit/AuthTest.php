<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $data = [
            'email' => 'phandinhman@gmail.com',
            'password' => '123123',
        ];

        $response = $this->json('POST', 'api/auth/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_at',
            'user' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testLoginFail()
    {
        $data = [
            'email' => 'phandinhman@gmail.com',
            'password' => '1231236',
        ];

        $response = $this->json('POST', 'api/auth/login', $data);

        $response->assertStatus(401);
    }
}
