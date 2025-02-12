<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirect_to_dashboard_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'sourav2@test.com'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    public function test_auth_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'sourav2@test.com'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_unauth_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_user_has_correct_name(): void
    {
        $user = User::factory()->create([
            'name' => 'sourav'
        ]);

        $this->assertEquals(ucfirst('sourav'), $user->name);
    }
}
