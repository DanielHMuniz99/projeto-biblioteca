<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_user_can_be_created()
    {
        $response = $this->post('/usuarios', [
            'name' => 'Daniel Muniz',
            'email' => 'daniel@test.com',
            'registration_number' => 'U-001',
        ]);

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseHas('users', ['email' => 'daniel@test.com']);
    }

    public function test_user_can_be_deleted()
    {
        $user = User::create([
            'name' => 'Maria',
            'email' => 'maria@test.com',
            'registration_number' => 'U-002',
        ]);

        $response = $this->delete("/usuarios/{$user->id}");

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseMissing('users', ['email' => 'maria@test.com']);
    }
}
