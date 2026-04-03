<?php
/*
Livewire tests that tests the ShowUsersWishlist livewire component. The component is responsible for rendering and deleting wishlisted items.
*/
namespace Tests\Feature\Livewire;

use App\Livewire\ShowUserWishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ShowUserWishlistTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ShowUserWishlist::class)
            ->assertStatus(200);
    }
}
