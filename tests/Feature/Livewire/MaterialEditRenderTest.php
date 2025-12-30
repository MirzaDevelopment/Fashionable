<?php
/*
Simple test of the MaterialEditRender livewire component. Component is used in rendering material categories, in Edit product panel
*/
namespace Tests\Feature\Livewire;

use App\Livewire\MaterialEditRender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Material;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialEditRenderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {


        Livewire::test(MaterialEditRender::class)
            ->assertStatus(200);
    }


    /** @test */
    public function test_component_exists_on_the_page()
    {

        $response = Livewire::test('edit-product-material')
            ->assertSeeLivewire('material-edit-render');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_material_is_rendered_properly()
    {


        Material::factory()->create(['material' => 'Poly',]);
        Material::factory()->create(['material' => 'Leather',]);

        Livewire::test(MaterialEditRender::class)
            ->assertSee('Poly')
            ->assertSee('Leather');
    }
}
