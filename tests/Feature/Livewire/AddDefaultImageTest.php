<?php
/*
Simple test of the AddDefaultImage livewire component. Component is used in adding the placeholder image when user changes/adds the new product color, untill the user picks the correct image for the product.
*/
namespace Tests\Feature\Livewire;

use App\Livewire\AddDefaultImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Image;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AddDefaultImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {


        Livewire::test(AddDefaultImage::class)
            ->assertStatus(200);
    }


    /** @test */
    public function test_component_exists_on_the_page()
    {
        
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $response = $this->actingAs($userAdmin)->get('addproduct')
            ->assertSeeLivewire(AddDefaultImage::class);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_default_image_exists_in_database()
    {

        Image::factory()->create(['image_path' => 'images/default.webp',]);

        $this->assertDatabaseHas("category_images", [
            "image_path" => "images/default.webp",
            

        ]);
            
    }

        /** @test */
    public function test_default_image_is_uploaded_in_database()
    {

        Image::factory()->create(['image_path' => 'images/default.webp',]);

             $userAdmin = User::factory()->create([
            'role' => "admin",
         ]);

          Livewire::actingAs($userAdmin)->test(AddDefaultImage::class)->call('defaultImageUpload')->assertStatus(200);

        $this->assertDatabaseHas("category_images", [
            "image_path" => "images/default.webp",
            

        ]);
            
    }
        /** @test */
    public function test_default_image_is_uploaded_only_by_admin()
    {

        Image::factory()->create(['image_path' => 'images/default.webp',]);

             $userAdmin = User::factory()->create([
            'role' => "admin",
         ]);
                      $userGuest = User::factory()->create([
            'role' => "gost",
         ]);

          Livewire::actingAs($userAdmin)->test(AddDefaultImage::class)->call('defaultImageUpload')->assertStatus(200);
          Livewire::actingAs($userGuest)->test(AddDefaultImage::class)->call('defaultImageUpload')->assertStatus(403);

        $this->assertDatabaseHas("category_images", [
            "image_path" => "images/default.webp",
            

        ]);
            
    }

    
}
