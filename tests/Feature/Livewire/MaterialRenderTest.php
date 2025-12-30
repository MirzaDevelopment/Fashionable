<?php
/*
Simple test of the MaterialRender (without Edit) livewire component. Component is used in rendering material categories from database, in upload product panel.
*/
namespace Tests\Feature\Livewire;

use App\Livewire\MaterialRender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Material;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialRenderTest extends TestCase
{
     use RefreshDatabase;
    /** @test */
    public function test_renders_successfully()
    {
        
        Livewire::test(MaterialRender::class)
            ->assertStatus(200);
    }


        /** @test */
    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $response = $this->actingAs($user)->get('addproduct')
            ->assertSeeLivewire(MaterialRender::class);
        $response->assertStatus(200);
       
    }

      /** @test */
    public function test_material_is_rendered_properly()
    {


        Material::factory()->create(['material' => 'Poly',]);
        Material::factory()->create(['material' => 'Leather',]);

        Livewire::test(MaterialRender::class)
            ->assertSee('Poly')
            ->assertSee('Leather');



    }   
    }

    

    

