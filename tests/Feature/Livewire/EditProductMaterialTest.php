<?php
/*
Simple test of the EditProductMaterial livewire component. Component is used in updating the product material categories in edit product panel (adding new or deleting old ones)
*/

namespace Tests\Feature\Livewire;

use App\Livewire\EditProductMaterial;
use App\Models\User;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditProductMaterialTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {

        Livewire::test(EditProductMaterial::class)
            ->assertStatus(200);
    }
    /** @test */
    public function test_component_exists_on_the_page()
    {
        Livewire::test('edit-product-material')
            ->assertSee('Materijal proizvoda'); //A button in the component that opens the material categories in

        Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        $user = User::factory()->create([
            'role' => "admin",
        ]);

        $this->actingAs($user)->get(route('editproduct', ['id' => 1]))
            ->assertSee("Product material"); //Same Button from component seen in blade view
    }



    /** @test */
    public function test_new_product_material_exists_in_database()
    {
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        $fakeMaterial = Material::factory()->create();
        $fakeProduct->materials()->attach($fakeMaterial->id);

        $this->assertDatabaseHas("products_materials", [
            "product_id" =>  $fakeProduct->id,
            "category_material_id" => $fakeMaterial->id,

        ]);
    }
    /** @test */
    public function test_old_product_material_vanishes_from_database()
    {
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        $fakeMaterial1 = Material::factory()->create();
        $fakeMaterial2 = Material::factory()->create();
        $fakeProduct->materials()->attach($fakeMaterial1->id);
        $fakeProduct->materials()->attach($fakeMaterial2->id);
        //Removing the entry in pivot table
        $fakeProduct->materials()->detach($fakeMaterial2->id);


        $this->assertDatabaseHas("products_materials", [
            "product_id" =>  $fakeProduct->id,
            "category_material_id" => $fakeMaterial1->id,

        ]);
        $this->assertDatabaseMissing("products_materials", [
            "product_id" =>  $fakeProduct->id,
            "category_material_id" => $fakeMaterial2->id,

        ]);
    }
    /** @test */
    public function test_product_material_is_added_to_product()
    {
        /*
        Adding material to product
        */
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeMaterial = Material::factory()->create(["material" => "linen"]);
        $currentMaterialArray = [0 => "polyester"]; //Mocking material already present
        $materialSelect = [0 => "linen"]; //The one user selected
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $this->actingAs($userAdmin);

        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialSelect)->call('editMaterials')->assertHasNoErrors();

        $this->assertDatabaseHas("products_materials", [
            "product_id" =>  $fakeProduct->id,
            "category_material_id" => $fakeMaterial->id,

        ]);
    }

    /** @test */
    public function test_product_material_is_removed_from_product()
    {
        /*
        Removing material to from product
        */
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeMaterial = Material::factory()->create(["material" => "polyester"]);
        $currentMaterialArray = [0 => "polyester"];
        $materialDeSelect = [0 => "polyester"];
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $this->actingAs($userAdmin);

        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialDeSelect)->call('editMaterials')->assertStatus(200);

        $this->assertDatabaseMissing("products_materials", [
            "product_id" =>  $fakeProduct->id,
            "category_material_id" => $fakeMaterial->id,

        ]);
    }

    public function test_product_material_is_added_to_product_only_by_admin()
    {
    
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeMaterial = Material::factory()->create(["material" => "linen"]);
        $currentMaterialArray = [0 => "polyester"]; //Mocking material already present
        $materialSelect = [0 => "linen"]; //The one user selected
        //Creating users
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $userGuest = User::factory()->create([
            'role' => "guest",
        ]);

        $this->actingAs($userAdmin);

        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialSelect)->call('editMaterials')->assertStatus(200);


        $this->actingAs($userGuest);
        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialSelect)->call('editMaterials')->assertStatus(403);
    }


    /** @test */
    public function test_product_material_is_removed_from_product_only_by_admin()
    {
 
        $fakeProduct = Product::factory()->create(['id' => 1, 'product_name' => 'Test Name', 'description' => 'Test description', 'total_stock' => 34]);
        session(['newProductModel' => $fakeProduct]);
        $fakeMaterial = Material::factory()->create(["material" => "polyester"]);
        $currentMaterialArray = [0 => "polyester"];
        $materialDeSelect = [0 => "polyester"];
        //Creating users
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $userGuest = User::factory()->create([
            'role' => "guest",
        ]);
        $this->actingAs($userAdmin);

        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialDeSelect)->call('editMaterials')->assertStatus(200);


        $this->actingAs($userGuest);
        Livewire::withQueryParams(['id' => $fakeProduct->id])->test(EditProductMaterial::class, ['product' => $fakeProduct])->set("currentMaterialArray", $currentMaterialArray)->set("materialSelect", $materialDeSelect)->call('editMaterials')->assertStatus(403);
    }
}
