<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_professional_can_create_service_with_valid_data(): void
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

    public function test_service_creation_fails_with_invalid_data(): void
    {
        $professional_user = User::factory()->create(['type' => 'professional']);

        $payload = [
            'price' => 100.00,
            'duration_minutes' => 60,
        ];

        $this->actingAs($professional_user)
            ->postJson('/api/services', $payload)
            ->assertStatus(422);

    }

    public function test_common_user_cannot_create_service(): void
    {
        $common_user = User::factory()->create(['type' => 'user']);

        $payload = [
            'name' => 'Test Service',
            'price' => 100.00,
            'duration_minutes' => 60,
        ];

        $this->actingAs($common_user)
            ->postJson('/api/services', $payload)
            ->assertStatus(403);
    }

    public function test_guest_cannot_create_service(): void
    {
        $payload = [
            'name' => 'Test Service',
            'price' => 100.00,
            'duration_minutes' => 60,
        ];

        $this->postJson('/api/services', $payload)
            ->assertStatus(401);
    }

    // TODO: Add tests for service retrieval, update, and deletion
    public function test_service_creation_returns_correct_json_structure(): void
    {

    }

    public function test_professional_can_update_service(): void
    {

    }

    public function test_professional_can_delete_own_service(): void
    {

    }
}
