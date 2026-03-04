<?php
/*
This is a livewire backend component used for rendering users wishlisted items. It is also used for deleting items from wishlist.
*/

namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\Product;
use Livewire\Component;
use Carbon\Carbon;

class ShowUserWishlist extends Component
{
    use WithPagination;

    public $user_id;
    private $user;
    public Carbon $currentDate;
    public string $empty = "Vaša lista željenih proizvoda je trenutno prazna.";

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->user_id = auth()->user()->id;
        $this->currentDate = Carbon::today();
    }





    //Removing wishlisted item
    public function deleteWishlistItem($parameter): void
    {

        auth()->user()->products()->detach($parameter);
    }


    public function render()
    {

        $products = Product::with('type', 'prices', "images", "tags", "materials", "colorsVariant", "colors", "sizesVariant", "users")->where("user_id", $this->user_id)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->join("wishlist_items", "wishlist_items.product_id", "=", "products.id")->join("users", "wishlist_items.user_id", "=", "users.id")->select('products.*', 'types.type_name', "price", "end_date", "discount")->distinct(["product_name"])->paginate(5);
        return view('livewire.show-user-wishlist', ["products" => $products]);
    }
}
