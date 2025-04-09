<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_make_an_appointment(): void
    {
        $user = User::factory()->create(['type' => 'user']);
        $professional = User::factory()->create(['type' => 'professional']);
        $service = Service::factory()->create(['professional_id' => $professional->id]);

        $payload = [
            'professional_id' => $professional->id,
            'service_id' => $service->id,
            'scheduled_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
        ];

        $response = $this->actingAs($user)->postJson('/api/appointments', $payload);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'user_id' => $user->id,
                    'professional_id' => $professional->id,
                    'service_id' => $service->id,
                    'scheduled_at' => $payload['scheduled_at'],
                    'status' => 'pending',
                ]
            ]);

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'professional_id' => $professional->id,
            'service_id' => $service->id,
        ]);
    }
}
