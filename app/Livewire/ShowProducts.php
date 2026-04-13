<?php
/*
This is a livewire backend component used for rendering ACTIVE products depending on the search filters. It is also used for SOFT DELETING selected products. It includes following methods:
- Mount method that incorporates Carbon library for date manipulation in Laravel.
- Search method that updates the frontend component with the results from the $search property. 
- Method to sort product data with ascending or descending order depending on the criterium ($sortToggle) and product property.
- Helper method to visually distinguish selected rows
- Method to delete selected products
- Helper method to clear checked rows
Pagination is also used
$variable - sort by product_name by default, asc or desc. Also sort by stock, discount, price, created_at, and discount status depending on admin click.
*/
namespace App\Livewire;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowProducts extends Component
{
    use WithPagination;

    public string $empty = "Proizvodi nisu pronađeni...";
    public int $totalQuantityLowLimit=15;
    public string $search = "";
    public User $user;
    public string $count = "";
    public array $checkBox = [];
    public Carbon $currentDate;
    public string $sortinator="product_name"; 
    public string $sortToggle="ASC";


    public function mount():void
    {
        $this->currentDate=Carbon::today();
    }
    //Storing the user search in variable and resetting the component
    public function updatedSearch(string $search):void
    {
        

        $this->search = $search;
        $this->resetPage();
    }

    //Sorting products by different column names
    public function sortProduct(string $parameter):void{
        if($this->sortToggle=="ASC"){;
        $this->sortinator=$parameter;
        $this->sortToggle="DESC";
    } else {
        $this->sortinator=$parameter;
        $this->sortToggle="ASC";
    }
    
}

    //Selecting product rows
    public function RowCheckBox(string $parameter):void
    {
       if(in_array($parameter, $this->checkBox)){
        $index=array_search($parameter, $this->checkBox);
        unset($this->checkBox[$index]);
        $this->count--;
       }else {
        $this->checkBox[] = $parameter;
        $this->count = count($this->checkBox);
        
        
    }

}

    //Deleting selected products 
    public function deleteProduct():void
    {
        Gate::authorize('delete', Product::class);
        $deletedProducts = [$this->checkBox];
        Product::destroy($deletedProducts[0]);
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

        $products = Product::with('type', 'prices', "images", "colorsVariant", "colors","sizesVariant")->whereAny(["product_name", "total_stock", "products.created_at", "prices.price", "end_date", "prices.discount", "start_date",  "type_name"], "like", $this->search . "%")->whereNull("prices.deleted_at")->join("prices", "prices.product_id","=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->select('products.*', 'types.type_name', "price", "end_date", "start_date", "discount")->orderBy($this->sortinator, $this->sortToggle)->paginate(15);
        return view('livewire.show-products', ["products"=>$products]);
    }
}
