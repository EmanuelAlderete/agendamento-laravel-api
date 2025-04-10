<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;
    public function test_professinal_can_create_a_schedule(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['type' => 'professional']);
        $this->actingAs($user)
            ->post('/api/schedules', [
<<<<<<< HEAD
                'professional_id' => $user->id,
=======
>>>>>>> 1ee288d17eaf4f4557c0420b52613362ea009dc3
                'weekday' => 1,
                'start_time' => '12:00:00',
                'end_time' => '20:00:00',
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('schedules', [
            'weekday' => 1,
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
            'professional_id' => $user->id,
        ]);
    }

    public function test_common_user_cannot_create_a_schedule(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['type' => 'user']);
        $this->actingAs($user)
            ->post('/api/schedules', [
                'weekday' => 1,
                'start_time' => '12:00:00',
                'end_time' => '20:00:00',
            ])
            ->assertStatus(403);
    }

    public function test_guest_cannot_create_a_schedule(): void
    {
        $this->postJson('/api/schedules', [
            'weekday' => 1,
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ])
            ->assertStatus(401);
    }

    public function test_fails_create_when_missing_required_field(): void
    {
        /** @var \App\Models\User $user */
<<<<<<< HEAD
        $user = User::factory()->create(['type' => 'professional']);
=======
        $user = User::factory()->create(['type' => 'user']);
>>>>>>> 1ee288d17eaf4f4557c0420b52613362ea009dc3

        $this->actingAs($user)
            ->postJson('/api/schedules', [])
            ->assertJsonMissing(['weekday', 'start_time', 'end_time'])
            ->assertStatus(422);
    }
}
