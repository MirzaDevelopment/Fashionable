<?php
/*This is a livewire backend component used for rendering products with ACTIVE discount.
- Products are sorted by from the highest to lowest discount %.
-It uses mount method that incorporates Carbon library for date manipulation in Laravel.
- It allows users to add discounted items the wishlist.
*/

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Price;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ShowDiscountedProducts extends Component
{
    public Carbon $currentDate;
    public string $sortinator = "discount";
    public array $wishListArray = [""];
    public array $wishListSuccess = [];
    public array $wishListFailed = [];
    public array $authErrorMessage = [];


    public function mount(): void
    {
        if (auth()->user()) {
            $wishListproduct = Wishlist::where("user_id", auth()->user()->id)->get();
            foreach ($wishListproduct as $wishlistItem) {
                $this->wishListArray[] = $wishlistItem->product_id;
            }
        }
        $this->currentDate = Carbon::today();
    }




    //Adding item to wishlist
    public function wishListItem(int $parameter): void
    {

        if (auth()->user()) {
            Gate::authorize('create', Wishlist::class);
            DB::beginTransaction();
            try {
                $product = Product::find($parameter);
                $price = Price::where("product_id", $parameter)->first();
                $product->users()->attach(auth()->user()->id, ["price_when_added" => $price->price]);
                DB::commit();
                $this->wishListArray[] = $parameter;
                $this->wishListSuccess[$parameter] = "Proizvod je dodan na listu želja";
            } catch (\Exception $e) {
                Log::error('Error occurred: ' . $e->getMessage());
                $this->wishListFailed[$parameter] = "Proizvod se već nalazi na listi želja.";
            }
        } else {

            $this->authErrorMessage[$parameter] = true;
        }
    }


    public function render()
    {
        $discountedProducts = Product::with('prices', "images", "colors", "tags", "genders", "materials", "colorsVariant", "sizesVariant")->whereDate('prices.end_date', '>=', Carbon::now())->whereDate("prices.start_date", '<=', Carbon::now())->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*',  "price", "end_date", "discount")->distinct(["product_name"])->orderBy($this->sortinator, 'desc')->limit(5)->get();
        return view('livewire.show-discounted-products', ["discountedProducts" => $discountedProducts]);
    }
}
