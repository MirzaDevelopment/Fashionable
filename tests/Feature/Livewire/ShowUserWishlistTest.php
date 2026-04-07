<?php
/*
Livewire tests that tests the ShowUsersWishlist livewire component. The component is responsible for rendering and deleting wishlisted items.
*/
namespace Tests\Feature\Livewire;

use App\Livewire\ShowUserWishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Price;
use App\Models\Color;
use App\Models\Size;
use App\Models\Type;
use App\Models\Material;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Wishlist;
use Tests\TestCase;

class ShowUserWishlistTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)->test(ShowUserWishlist::class)
            ->assertStatus(200);
    }

        /** @test */
    public function test_user_can_view_his_wishlist()
    {
        $user = User::factory()->create();
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

        Wishlist::factory()->create(["user_id" => $user->id, "product_id"=>$fakeProduct->id]);

        Livewire::actingAs($user)->test(ShowUserWishlist::class)
            ->assertSee("Test Name")
            ->assertSee("Green");

      
    }
}
