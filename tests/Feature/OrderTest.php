<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOrder()
    {
        $request = [
            'product_id' => 1,
            'quantity' => 2,
        ];

        $response = $this->post('api/order', $request);
        $response
        ->assertStatus(201)
        ->assertSeeText(['message', 'You have successfully ordered this product.']);
    }

    public function testOrderInsuffecient()
    {
        $request = [
            'product_id' => 2,
            'quantity' => 9999,
        ];

        $response = $this->post('api/order', $request);
        \Log::info($response->getContent());
        $response
        ->assertStatus(400)
        ->assertSeeText(['message', 'Failed to order this product due to unavailability of the stock']);
    }
}
