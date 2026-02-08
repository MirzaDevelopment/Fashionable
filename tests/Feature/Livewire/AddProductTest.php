<?php
/*
Simple test of the AddProduct livewire component. It tests the rendering of the component, It's existance in the view and DB, and the upload functionality of the component.
*/

namespace Tests\Feature\Livewire;

use App\Livewire\AddProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Price;
use App\Models\User;
use App\Models\Color;
use App\Models\Image;
use App\Models\Size;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;
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
        $fakeImage = UploadedFile::fake()
            ->image('product.jpg', 800, 800) // width x height
            ->size(500); // size in KB
        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 0
        ]);
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        Livewire::actingAs($userAdmin)->test(AddProduct::class)->set("productName", "Test Name")->set("productDescription", "Test description")->set("productPrice", $fakePrice->price)->set("colorSelect", ["blue"])->set("genderSelect", ["male"])->set("typeSelect", ["Boots"])->set("materialSelect", ["Leather"])->set("sizeSelect", [$fakeSize])->set("productImage", $fakeImage)->call('uploadProduct')->assertHasNoErrors();

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
            "stock_quantity" => 0,
        ]);
    }

    /** @test */
    public function test_product_is_uploaded_in_database_only_by_admin()
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
        $userGuest = User::factory()->create([
            'role' => "gost",
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
            "stock_quantity" => 0,
        ]);
    }
}
