<?php
/*
Simple test of rendering the app dashboard depending on the logged in user.
*/
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    public function test_proper_dashboard_can_be_rendered(): void
    {
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        $user = User::factory()->create([
            'role' => "guest",
        ]);
        $response = $this->actingAs($userAdmin)->get('dashboard');
        $response->assertViewIs('dashboard');
        $response = $this->actingAs($user)->get('dashboardusers');
        $response->assertViewIs('dashboardusers');
    }


}
