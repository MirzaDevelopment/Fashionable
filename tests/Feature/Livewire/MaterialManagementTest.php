<?php
/*
Livewire tests of "MaterialManagement" component. Component is responsible for inserting and deleting material categories for product in database (wool, silk, linen etc).
*/

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\Material;
use App\Models\User;
use App\Livewire\MaterialManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;


use Tests\TestCase;

class MaterialManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_inserts_material_categories_in_table()
    {


        $material1 = Material::factory()->create(['material' => 'Silk',]);
        $material2 = Material::factory()->create(['material' => 'Wool',]);

        $arrayMaterials = [$material1, $material2];

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        Livewire::actingAs($userAdmin)->test(MaterialManagement::class)->set('materials',  $arrayMaterials)->call('insertMaterial')->assertStatus(200);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material1->id,
            "material" => $material1["material"],
            "deleted_at" => null,

        ]);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material2->id,
            "material" => $material2["material"],
            "deleted_at" => null,

        ]);
    }

    /** @test */
    public function test_only_admin_can_insert_material_categories_in_table()
    {


        $material1 = Material::factory()->create(['material' => 'Silk',]);
        $material2 = Material::factory()->create(['material' => 'Wool',]);

        $arrayMaterials = [$material1, $material2];

        $userGuest = User::factory()->create([
            'role' => "guest",
        ]);

        Livewire::actingAs($userGuest)->test(MaterialManagement::class)->set('materials',  $arrayMaterials)->call('insertMaterial')->assertStatus(403);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material1->id,
            "material" => $material1["material"],
            "deleted_at" => null,

        ]);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material2->id,
            "material" => $material2["material"],
            "deleted_at" => null,

        ]);
    }

    /** @test */
    public function test_multiple_material_categories_can_be_created()
    {
        // Create 10 material categories
        $materialCategories = Material::factory()->count(5)->sequence(
            ['material' => 'wool'],
            ['material' => 'silk'],
            ["material" => "leather"],
            ["material" => "poly"],
            ["material" => "linen"]
        )->create();

        // Assert that the categories exist in the database
        $this->assertCount(5, $materialCategories);
    }

    /** @test */
    public function test_deletes_material_categories_in_table()
    {

        $material1 = Material::factory()->create(['material' => 'Wool',]);

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $material1Id = $material1["id"];
        $this->actingAs($userAdmin);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material1->id,
            "material" => "Wool",
            "deleted_at" => null,

        ]);

        Livewire::test(MaterialManagement::class)->call('deleteMaterialCategory', $material1Id);

        $this->assertDatabaseHas('category_materials', [
            'id' => $material1->id,
            "material" => "Wool",
            'deleted_at' => date("Y-m-d H:i:s"),

        ]);
    }

    /** @test */
    public function test_only_admin_can_delete_material_categories()
    {
        $user = User::factory()->create(['name' => 'Kenan Hikmetov', 'role' => "guest"]);
        $material2 = Material::factory()->create(['material' => 'Silk',]);

        $material2Id = $material2["id"];
        $this->actingAs($user);

        Livewire::test(MaterialManagement::class)->call('deleteMaterialCategory', $material2Id)->assertStatus(403);

        $this->assertDatabaseHas("category_materials", [
            "id" => $material2->id,
            "material" => "Silk",
            "deleted_at" => null,

        ]);
    }
}
