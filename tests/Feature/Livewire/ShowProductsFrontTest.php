<?php
/*
Livewire tests that test the ShowProductsFront livewire component. The component is responsible for rendering the products on the first page (/shop).
*/
namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\Product;
use App\Livewire\AddProduct;
use App\Livewire\ShowProductsFront;
use Tests\TestCase;
use App\Models\Price;
use App\Models\User;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProductsFrontTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {
        Livewire::test(ShowProductsFront::class)
            ->assertStatus(200);
    }

    /** @test */
    public function test_component_exists_on_the_page()
    {
  
        $response = $this->get('/shop')
            ->assertSeeLivewire(ShowProductsFront::class);
        $response->assertStatus(200);
    }


        /** @test */
    public function test_renders_front_products_from_database()
    {
     $typeSelect = "";
     $genderSelect = [];
     $tagSelect = [];
     $search = "";

        $fakeProduct = Product::factory()->create(['product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 0]);
        $fakePrice = Price::factory()->create(['product_id' => $fakeProduct->id, "deleted_at"=>null]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();
        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 0
        ]);

        if (!$typeSelect && !$tagSelect && !$genderSelect) {
        Livewire::test(ShowProductsFront::class)->set('search', 'Test')
            ->assertSee('Test Name');
            
    }
   }
}
