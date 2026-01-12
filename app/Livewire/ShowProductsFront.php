<?php
/*
This is a livewire backend component used for rendering ACTIVE products depending on the search filters.  It includes following methods:
- Search method that updates the frontend component with the results from the $search property. 
- TypeSelect, GenderSelect and Tagselect methods that update the corresponding class properties with the chosen categories on the front.
- Clear all method to delete the chosen filters and reset the product grid
- Method to sort product data with ascending or descending price order 
- Render method that returns different products in views depending on the chosen filters (explained more there)
Pagination is also used
$sortinator - sort by asc or desc (product name) or price.
*/

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Product;
use Carbon\Carbon;

class ShowProductsFront extends Component
{
    
    use WithPagination;
    public Carbon $currentDate;
    public array $selectedTypesContainer = []; //Container array used to store selected items for better visual clarity
    public string $typeSelect = "";
    public array $genderSelect = [];
    public array $tagSelect = [];
    public string $empty = "Proizvodi nisu pronađeni...";
    public string $search = "";
    const DELIVERY = 9.50; //Shipping cost
    public string $sortinator = "type_name";
    public string $sortToggle = "ASC";

  public function mount(): void
    {
        $this->currentDate=Carbon::today();
    }

    //Storing the user search in variable and resetting the component
    public function updatedSearch(string $search): void
    {

        $this->search = $search;
        $this->typeSelect = "";
        $this->selectedTypesContainer = [];
        $this->genderSelect = [];
        $this->tagSelect = [];
        $this->resetPage();
    }


    //Visual change of selected product types
    public function TypeSelect(string $parameter): void
    {
        if (in_array($parameter, $this->selectedTypesContainer)) {
            $index = array_search($parameter, $this->selectedTypesContainer);
            unset($this->selectedTypesContainer[$index]);
            $this->typeSelect = "";
        } else {

            $this->selectedTypesContainer[] = $parameter;
            $this->typeSelect = $parameter;
        }

        //Visually represent the selected type (remove the last selected)
        foreach ($this->selectedTypesContainer as $key => $item) {
            if (count($this->selectedTypesContainer) > 1) {
                unset($this->selectedTypesContainer[$key]);
            }
        }
    }

    //Visual change of selected product genders
    public function GenderSelect(string $parameter): void
    {

        if (in_array($parameter, $this->genderSelect)) {
            $index = array_search($parameter, $this->genderSelect);
            unset($this->genderSelect[$index]);
        } else {

            $this->genderSelect[] = $parameter;
        }
    }


    //Visual change of selected product tags
    public function TagSelect(string $parameter): void
    {

        if (in_array($parameter, $this->tagSelect)) {
            $index = array_search($parameter, $this->tagSelect);
            unset($this->tagSelect[$index]);
        } else {

            $this->tagSelect[] = $parameter;
        }
    }

    //clearing all selected categories
    public function clearAll(): void
    {
        $this->typeSelect = "";
        $this->selectedTypesContainer = [];
        $this->genderSelect = [];
        $this->tagSelect = [];
    }
    //Sorting products by different column names
    public function sortProduct(string $parameter): void
    {
        if ($this->sortToggle == "ASC") {;
            $this->sortinator = $parameter;
            $this->sortToggle = "DESC";
        } else {
            $this->sortinator = $parameter;
            $this->sortToggle = "ASC";
        }
    }





    public function render()
    {

        /*
        1. Show products for situation when user selects one or more tag/s from tag category
        */
        if ($this->tagSelect && !$this->typeSelect && !$this->genderSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "materials","colorsVariant","colors","sizesVariant")->whereIn('category_tags.tag', $this->tagSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->select('products.*', 'types.type_name', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_tags.tag)=?', [count($this->tagSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            2. Show products for situation when user selects one product type from type category
            */
        } else if ($this->typeSelect && !$this->tagSelect && !$this->genderSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags","materials","colorsVariant", "colors", "sizesVariant")->where('types.type_name', $this->typeSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->select('products.*', 'types.type_name', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            3. Show products for situation when user selects one or more genders from gender category
            */
        } else if ($this->genderSelect && !$this->typeSelect && !$this->tagSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant", "colors", "sizesVariant")->whereIn('category_genders.gender', $this->genderSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*', 'types.type_name', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_genders.gender)=?', [count($this->genderSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            4. Show products for situation when user selects one or more genders from gender category AND one or more tags from tag category
            */
        } else if ($this->genderSelect  && $this->tagSelect && !$this->typeSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant","colors","sizesVariant")->whereIn('category_genders.gender', $this->genderSelect)->whereIn('category_tags.tag', $this->tagSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*', 'types.type_name', DB::raw('MAX(prices.price) as price'), DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_tags.tag)=? AND count(DISTINCT category_genders.gender)=?', [count($this->tagSelect), count($this->genderSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            4. Show products for situation when user selects one type from from type category AND one or more tags from tag category
            */
        } else if ($this->typeSelect  && $this->tagSelect && !$this->genderSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant","colors","sizesVariant")->whereIn('category_tags.tag', $this->tagSelect)->where('types.type_name', $this->typeSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->select('products.*', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_tags.tag)=?', [count($this->tagSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            5. Show products for situation when user selects one type from type category AND one or more genders from gender category
            */
        } else if ($this->typeSelect  && $this->genderSelect && !$this->tagSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant","colors","sizesVariant")->whereIn('category_genders.gender', $this->genderSelect)->where('types.type_name', $this->typeSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*', 'types.type_name', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_genders.gender)=?', [count($this->genderSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            6. Show products for situation when user selects one type from type category AND one or more genders from gender category AND one or more tags from tag category
            */
        } else if ($this->typeSelect && $this->genderSelect && $this->tagSelect) {
            $this->resetPage();
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant","colors","sizesVariant")->whereIn('category_genders.gender', $this->genderSelect)->whereIn('category_tags.tag', $this->tagSelect)->where('types.type_name', $this->typeSelect)->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->join("products_genders", "products_genders.product_id", "=", "products.id")->join("category_genders", "products_genders.category_gender_id", "=", "category_genders.id")->select('products.*', 'types.type_name', DB::raw('MAX(end_date) as end_date'), DB::raw('MAX(prices.price) as price'), DB::raw('MAX(prices.discount) as discount'))->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->groupBy("products.id")->havingRaw('count(DISTINCT category_tags.tag)=? AND count(DISTINCT category_genders.gender)=?', [count($this->tagSelect), count($this->genderSelect)])->paginate(15);
            return view('livewire.show-products-front', ["products" => $products]);
            /*
            7. Show products for situation when user searches for product name, product type or tag in search field
            */
        } else {
            $products = Product::with('type', 'prices', "images", "tags", "materials","colorsVariant","colors","sizesVariant")->whereAny(["product_name", "prices.price", "end_date", "prices.discount", "type_name", "tag"], "like", "%" . $this->search . "%")->whereNull("prices.deleted_at")->join("prices", "prices.product_id", "=", "products.id")->join('types', 'types.id', '=', 'products.type_id')->join("products_tags", "products_tags.product_id", "=", "products.id")->join("category_tags", "products_tags.category_tag_id", "=", "category_tags.id")->select('products.*', 'types.type_name', "price", "end_date", "discount")->distinct(["product_name"])->orderBy($this->sortinator, $this->sortToggle)->paginate(25);
            return view('livewire.show-products-front', ["products" => $products]);
        }
    }
}
