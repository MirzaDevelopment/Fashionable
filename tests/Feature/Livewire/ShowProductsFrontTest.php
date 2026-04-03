<?php
/*
Livewire tests that test the ShowProductsFront livewire component. The component is responsible for rendering the products on the first page (/shop). It also includes the add product to wishlist functionality test
*/

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\Product;
use App\Livewire\AddProduct;
use App\Livewire\ShowProductsFront;
use Tests\TestCase;
use App\Models\Price;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Material;
use App\Models\Type;
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
 
        //Creating fake variables
        $fakeProduct = Product::factory()->create(['product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 0]);
        Price::factory()->create(['product_id' => $fakeProduct->id, "deleted_at" => null]);
        $fakeColor = Color::factory()->create();
        $fakeType=Type::factory()->create();
        $fakeTag=Tag::factory()->create();
        $fakeMaterial = Material::factory()->create();
        $fakeImage = Image::factory()->create();
        $fakeSize = Size::factory()->create();
        //Creating pivot tables
        $fakeProduct->type($fakeType->id);
        $fakeProduct->materials()->attach($fakeMaterial->id);
        $fakeProduct->tags()->attach($fakeTag->id);
        $fakeProduct->colors()->attach($fakeColor->id);
        $fakeProduct->images()->attach($fakeImage->id, [
            'category_color_id' => $fakeColor->id,
        ]);

        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 25
        ]);
     
        
            Livewire::test(ShowProductsFront::class)
                ->assertSee('Test Name');
        
    }

        /** @test */
    public function add_product_to_wishlist()
    {

  
    }
}
