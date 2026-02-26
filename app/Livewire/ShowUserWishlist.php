<?php
/*
This is a livewire backend component used for rendering users wishlisted items. It is also used for deleting items from wishlist.
*/
namespace App\Livewire;

use Livewire\Component;

class ShowUserWishlist extends Component
{
    public function render()
    {
        return view('livewire.show-user-wishlist');
    }
}
