<?php
/*
Livewire tests used to test the rendering of the components and their presence on categories blade view 
*/
namespace Tests\Feature\Livewire;

use App\Livewire\HeelManagement;
use App\Livewire\MaterialManagement;
use App\Livewire\TypeManagement;
use App\Livewire\ColorManagement;
use App\Models\User;
use App\Livewire\GenderManagement;
use App\Livewire\TagManagement;
use App\Livewire\SizeManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RenderCategoryComponentsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_all_renders_successfully()
    {
        Livewire::test(MaterialManagement::class)
            ->assertStatus(200);
        Livewire::test(TypeManagement::class)
            ->assertStatus(200);
        Livewire::test(HeelManagement::class)
            ->assertStatus(200);
        Livewire::test(ColorManagement::class)
            ->assertStatus(200);
        Livewire::test(GenderManagement::class)
            ->assertStatus(200);
        Livewire::test(TagManagement::class)
            ->assertStatus(200);
        Livewire::test(SizeManagement::class)
            ->assertStatus(200);
    }


    /** @test */
    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(MaterialManagement::class);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(TypeManagement::class);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(HeelManagement::class);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(ColorManagement::class);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(TagManagement::class);
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get('categories')
            ->assertSeeLivewire(SizeManagement::class);
        $response->assertStatus(200);
    }

}
