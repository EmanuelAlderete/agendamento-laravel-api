<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_a_service(): void
    {
        $professional_user = User::factory()->create(['type' => 'professional']);

        $payload = [
            'name' => 'Test Service',
            'price' => 100.00,
            'duration_minutes' => 60,
        ];

        $this->actingAs($professional_user)
            ->postJson('/api/services', $payload)
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'price' => $payload['price'],
                    'duration_minutes' => $payload['duration_minutes'],
                    'professional_id' => $professional_user->id,
                ]
            ]);

        $this->assertDatabaseHas('services', [
            'professional_id' => $professional_user->id,
            'name' => $payload['name'],
            'price' => $payload['price'],
            'duration_minutes' => $payload['duration_minutes'],
        ]);


    }
}
