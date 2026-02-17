<?php
/*This is a livewire backend component used for rendering products with ACTIVE discount.
- Products are sorted by from the highest to lowest discount %.
-It uses mount method that incorporates Carbon library for date manipulation in Laravel.
- It allows users to add discounted items the wishlist.
*/

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Carbon\Carbon;

class ShowDiscountedProducts extends Component
{
public Carbon $currentDate;
public string $sortinator = "discount";
public array $wishListArray=[""];


    public function mount(): void
    {
        $this->currentDate=Carbon::today();
    }




    //Adding item to wishlist
    public function wishListItem(int $parameter): void
    {
        if(in_array($parameter, $this->wishListArray)){
        $index=array_search($parameter, $this->wishListArray);
        unset($this->wishListArray[$index]);
       }else {
        $this->wishListArray[] = $parameter;
        
    }

    }


    public function render()
    {
        $discountedProducts = Product::with('prices', "images", "colors","tags", "genders", "materials", "colorsVariant","sizesVariant")->whereDate('prices.end_date', '>=', Carbon::now())->whereDate("prices.start_date", '<=', Carbon::now())->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*',  "price", "end_date", "discount")->distinct(["product_name"])->orderBy($this->sortinator, 'desc')->limit(5)->get();
        return view('livewire.show-discounted-products', ["discountedProducts" => $discountedProducts]);
    }
}
