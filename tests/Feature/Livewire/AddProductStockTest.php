<?php
/*
Simple test of the AddProductStock livewire component. Component is used in updating the product stock values in product_variants pivot table and total stock in main products table.
*/

namespace Tests\Feature\Livewire;

use Faker\Factory as Faker;
use App\Livewire\AddProductStock;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddProductStockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_component_exists_on_the_page()
    {
        $faker = Faker::create();
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);


        
        // Insert a row into the 'category_colors' table (assuming the 'category_colors' table exists)
        $category_color_id = DB::table('category_colors')->insertGetId([
            'color' => "green",
            "hex_code"=>"#5bd742",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert a row into the 'category_sizes' table (assuming the 'category_sizes' table exists)
        $category_size_id = DB::table('category_sizes')->insertGetId([
            'size' => "medium",
            'size_type' => "shoe",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
            DB::table('products_variants')->insert([
                'product_id' => 1,
                'category_color_id' => $category_color_id,
                'category_size_id' => $category_size_id,
                'stock_quantity' => $faker->numberBetween(0, 32767),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
        $fakeVariantStocks = DB::table("products_variants")->where('product_id', 1)->get();
        $fakeColors  = Color::findMany($fakeVariantStocks->pluck('category_color_id'));
        $fakeSizes   = Size::findMany($fakeVariantStocks->pluck('category_size_id'));
        foreach ($fakeVariantStocks as $fakeVariant) {
        $fakeColor[] = $fakeColors->firstWhere('id', $fakeVariant->category_color_id);
        $fakeSize[]  = $fakeSizes->firstWhere('id', $fakeVariant->category_size_id);
        }

         Livewire::test(AddProductStock::class, ['product_id' => 1])
            ->assertSee('green')   // Check if 'Red' color is visible in the component
            ->assertSee('medium') // Check if 'Medium' size is visible in the component
            ->assertSeeLivewire('add-product-stock'); // Check if the Livewire component is rendered
    }

    /** @test */
    public function test_product_stock_exists_in_database()
    {

        $product = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();

        $product->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 25
        ]);
        $this->assertDatabaseHas("products_variants", [
            "product_id" =>  $product->id,
            "category_color_id" => $fakeColor->id,
            "category_size_id" => $fakeSize->id,
            "stock_quantity" => 25,

        ]);
    }

    /** @test */
    public function test_product_stock_is_updated_in_database()
    {
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();
        //Creating an object to set the "variantStocks" variable
        $variantSizeStdObject = [(object)["id" => 1, "product_id" => $fakeProduct->id, "category_color_id" => $fakeColor->id, "category_size_id" => $fakeSize->id, "stock_quantity" => 25]];
        ($variantSizeStdObject);
        //Creating the collection from mentioned object
        $variantSizeCollection = collect($variantSizeStdObject);

        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 25
        ]);
        $userAdmin = User::factory()->create([
            "id" => 2,
            'role' => "admin",
        ]);
        $this->actingAs($userAdmin);

        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(AddProductStock::class, ['product' => $fakeProduct])->set("productStocks", [50])->set("variantStocks", $variantSizeCollection)
            ->call('updateStock');


        $pivot = $fakeProduct->colorsVariant()->where('category_color_id', $fakeColor->id)->first()->pivot;
        $this->assertEquals(50, $pivot->stock_quantity);
    }
    /** @test */
    public function test_product_stock_is_updated_in_database_only_by_admin()
    {

        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeColor = Color::factory()->create();
        $fakeSize = Size::factory()->create();
        //Creating an object to set the "variantStocks" variable
        $variantSizeStdObject = [(object)["id" => 1, "product_id" => $fakeProduct->id, "category_color_id" => $fakeColor->id, "category_size_id" => $fakeSize->id, "stock_quantity" => 25]];
        ($variantSizeStdObject);
        //Creating the collection from mentioned object
        $variantSizeCollection = collect($variantSizeStdObject);

        $fakeProduct->colorsVariant()->attach($fakeColor->id, [
            'category_size_id' => $fakeSize->id,
            'stock_quantity' => 25
        ]);

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        $userGuest = User::factory()->create([
            'role' => "gost",
        ]);

        $this->actingAs($userGuest);
        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(AddProductStock::class, ['product' => $fakeProduct])->set("productStocks", [50])->set("variantStocks", $variantSizeCollection)->call('updateStock')->assertStatus(403);


        $this->actingAs($userAdmin);
        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(AddProductStock::class, ['product' => $fakeProduct])->set("productStocks", [50])->set("variantStocks", $variantSizeCollection)->call('updateStock')->assertStatus(200);
    }
}
