<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_fails_when_required_fields_are_missing(): void
    {
        $this->postJson('/api/register', [])
            ->assertJsonMissing([
                'name',
                'email',
                'password'
            ]);
    }

    public function test_validation_fails_when_required_fields_have_incorrect_values(): void
    {
        $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123'
        ])
            ->assertJsonMissing([
                'name',
                'email',
                'password'
            ]);
    }
    public function test_guest_can_register(): void
    {
        $payload = [
            "name" => "Test",
            "email" => "test@test.com",
            "password" => "123456"
        ];

        $this->postJson('/api/register', $payload)
            ->assertCreated();
    }

    public function test_authenticated_user_cannot_register(): void
    {
        $user = User::factory()->create();
        $payload = [
            "name" => "Test",
            "email" => "test@test.com",
            "password" => "123456"
        ];

        $this->actingAs($user)
            ->postJson('/api/register', $payload, ['Accept' => 'application/json'])
            ->assertStatus(403);
    }
}
