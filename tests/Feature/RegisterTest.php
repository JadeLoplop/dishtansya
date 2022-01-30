<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;

class RegisterTest extends TestCase
{
    // use RefreshDatabase;
    public function setUp() :void {
        parent::setUp();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {

        $request = [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ];

        $response = $this->post('api/register', $request);
        $response
        ->assertStatus(201)
        ->assertSeeText(['message', 'User successfully registered.']);
    }

    public function testRegisterDuplicate()
    {
        $user = User::factory()->create(['email' => 'backend@multisyscorp.com', 'password' => Hash::make('test123')]);

        $request = [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ];

        $response = $this->post('api/register', $request);
        $response
        ->assertStatus(400)
        ->assertSeeText(['message', 'Email already taken.']);
    }

    public function tearDown() : void
    {
        User::where('email', 'backend@multisyscorp.com')->delete();

        parent::tearDown();
    }
}
