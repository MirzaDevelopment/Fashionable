<?php
/*
Simple test of the AddDefaultImage livewire component. Component is used in adding the placeholder image when user changes/adds the new product color, untill the user picks the correct image for the product.
*/

namespace Tests\Feature\Livewire;

use App\Livewire\AddProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Price;
use App\Models\User;
use App\Models\Color;
use App\Models\Size;
use Livewire\Livewire;
use Tests\TestCase;

class AddProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {


        Livewire::test(AddProduct::class)
            ->assertStatus(200);
    }

    /** @test */
    public function test_component_exists_on_the_page()
    {

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $response = $this->actingAs($userAdmin)->get('addproduct')
            ->assertSeeLivewire(AddProduct::class);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_product_exists_in_database()
    {

        Product::factory()->create(['product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);

        $this->assertDatabaseHas("products", [
            "product_name" => "Test Name",
            "description" => "Test description",
            "total_stock" => 34,

        ]);
    }
    /** @test */
    public function test_product_is_uploaded_in_database()
    {

        $fakeProduct = Product::factory()->create(['product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 0]);

        $fakePrice = Price::factory()->create(['product_id' => $fakeProduct->id]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();
        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 0
        ]);
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        Livewire::actingAs($userAdmin)->test(AddProduct::class)->call('uploadProduct')->assertStatus(200);

        $this->assertDatabaseHas("products", [
            "product_name" => "Test Name",
            "description" => "Test description",
            "total_stock" => 0,

        ]);

        $this->assertDatabaseHas("prices", [
            "product_id" => $fakeProduct->id,
            "price" => $fakePrice->price,
            "discount" => $fakePrice->discount,
            "start_date" => $fakePrice->start_date,
            "end_date" => $fakePrice->end_date
        ]);

            $this->assertDatabaseHas("products_variants", [
            "product_id" => $fakeProduct->id,
            "category_color_id" => $fakeColor->id,
            "category_size_id" => $fakeSize->id,
            "stock_quantity"=>0,
        ]);
    }

    /** @test */
    public function test_product_is_uploaded_in_database_only_by_admin()
    {

        $fakeProduct=Product::factory()->create(['product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 0]);
        $fakePrice = Price::factory()->create(['product_id' => $fakeProduct->id]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();
        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 0
        ]);

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        $userGuest = User::factory()->create([
            'role' => "guest",
        ]);


        Livewire::actingAs($userAdmin)->test(AddProduct::class)->call('uploadProduct')->assertStatus(200);
        Livewire::actingAs($userGuest)->test(AddProduct::class)->call('uploadProduct')->assertStatus(403);

        $this->assertDatabaseHas("products", [
            "product_name" => "Test Name",
            "description" => "Test description",
            "total_stock" => 0,

        ]);

                $this->assertDatabaseHas("prices", [
            "product_id" => $fakeProduct->id,
            "price" => $fakePrice->price,
            "discount" => $fakePrice->discount,
            "start_date" => $fakePrice->start_date,
            "end_date" => $fakePrice->end_date
        ]);

            $this->assertDatabaseHas("products_variants", [
            "product_id" => $fakeProduct->id,
            "category_color_id" => $fakeColor->id,
            "category_size_id" => $fakeSize->id,
            "stock_quantity"=>0,
        ]);
    }
}
