<?php
/*
This is a livewire backend component used for rendering DELETED products depending on the search filters. It is also used for RESTORING selected products. It includes following methods:
- Mount method that incorporates Carbon library for date manipulation in Laravel.
- Search method that updates the frontend component with the results from the $search property. 
- Method to sort product data with ascending or descending order depending on the criterium ($sortToggle) and product property.
- Helper method to visually distinguish selected rows
- Method to restore selected products
- Helper method to clear checked rows
Pagination is also used
*/
namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Livewire\Component;

class ShowDeletedProducts extends Component
{

    use WithPagination;

    public string $empty = "No products found...";
    public string $search = "";
    public User $user;
    public string $count = "";
    public array $checkBox = [];
    public Carbon $currentDate;
    public string $variable = "product_name"; //sort by product_name, asc or desc
    public string $sortToggle = "ASC";


    public function mount():void
    {
        $this->currentDate = Carbon::today();
    }
    //Storing the user search in variable and resetting the component
    public function updatedSearch(string $search):void
    {


        $this->search = $search;
        $this->resetPage();
    }

    //Sorting products by different column names
    public function sortProduct(string $parameter):void
    {
        if ($this->sortToggle == "ASC") {;
            $this->variable = $parameter;
            $this->sortToggle = "DESC";
        } else {
            $this->variable = $parameter;
            $this->sortToggle = "ASC";
        }
    }

    //Selecting product rows
    public function RowCheckBox(string $parameter):void
    {
        if (in_array($parameter, $this->checkBox)) {
            $index = array_search($parameter, $this->checkBox);
            unset($this->checkBox[$index]);
            $this->count--;
        } else {
            $this->checkBox[] = $parameter;
            $this->count = count($this->checkBox);
           
        }
    }
    //restoring selected products 
    public function restoreProduct():void
    {
        Gate::authorize('restore', Product::class); //Authorisation for admin
        $deletedProducts = [$this->checkBox];
        Product::onlyTrashed()->whereIn("id", $deletedProducts[0])->restore();
        $this->count = "";
    }

    //Clearing checked
    public function clearCheckbox():void
    {
        $this->checkBox = [];
        $this->count = "";
    }


    public function render()
    {
        $products = Product::with('type', 'prices', "images", "colorsVariant","sizesVariant")->onlyTrashed()->whereAny(["product_name", "products.created_at", "prices.price", "end_date", "prices.discount", "total_stock", "type_name"], "like", "%" . $this->search . "%")->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->select('products.*', 'types.type_name', "price", "end_date", "discount")->orderBy($this->variable, $this->sortToggle)->paginate(15);
        return view('livewire.show-deleted-products', ["products" => $products]);
    }
}
