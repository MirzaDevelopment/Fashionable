<?php
/*
Simple test of rendering categories view depending if user is authenticated.
*/
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RenderCategoriesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_categories_view_can_be_rendered(): void
    {
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $response = $this->actingAs($userAdmin)->get('categories');
        $response->assertViewIs('categories');

    }
}
