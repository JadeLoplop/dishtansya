<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;

class LoginTest extends TestCase
{
    // use RefreshDatabase;
    public function setUp() :void {
        parent::setUp();

        User::factory()->create(['email' => 'backend@multisyscorp.com', 'password' => Hash::make('test123')]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $request = [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ];

        $response = $this->post('api/login', $request);
        $response
        ->assertOk()
        ->assertJsonStructure(['access_token']);
    }

    public function testLoginInvalid()
    {
        $request = [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test121231233'
        ];

        $response = $this->post('api/login', $request);
        $response
        ->assertStatus(401)
        ->assertSeeText(['message', 'Invalid credentials']);
    }

    public function tearDown() : void
    {
        User::where('email', 'backend@multisyscorp.com')->delete();

        parent::tearDown();
    }
}
