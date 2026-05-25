<?php
/*
This is a backend class in livewire framework that does all the backend logic in the update product stock functionality. It is named as "AddProductStock" because it adds the actuall quantities first time, from the default "0". However, it is a classic column update.
It includes:
- Mount function to obtain the product id from URL with Request object. Which is then used to obtain the product model.
- Using the obtained product model, we get the pivot product_variants table, and therefore colors, sizes, and stock quantities (also product image!)
- All the validation rules with corresponding messages.
- Stock update method with admin authorisation wrapped in transaction.
- During the update, the sum of all product variation quantity is added to the main product table and displayed during the product search (admin products table), just as the bottom stock limit the user chose .
- Small function backToProduct to return the admin with back button to correct panel (show products, add product or modify product). After the update, livewire doesn't seem to care much about the url parameters, and they seems to vanish.
*/

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AddProductStock extends Component
{
    const minQuantity = 15;
    public ?int $requestId = null;
    public ?string $requestRoute = null;
    public Product $product;
    public object $variantStocks;
    public object $images;
    public string $message;
    #[Validate]
    public array $productStocks;
    #[Validate]
    public int $bottomStocksLimit;
    public bool $toggle = false;

    public function mount(Request $request): void
    {


        $this->requestId = $request->id; //Used to make sure user gets back to correct page after update 
        $this->requestRoute = $request->route; //...also to make sure user gets back to correct page after update
        //Mostly important to show the admin current product stock data and bottom stock limit
        $this->product = Product::with("sizesVariant", "colorsVariant")->find($request->id);
        //To show the user current chosen bottom limit for product stock
        $this->bottomStocksLimit=$this->product->bottom_stock_limit;
        //Making it available through other livewire components
        session(['newProductModel' => $this->product]); //Important if user gets here from the show product icon.
        $this->images = $this->product->images;
    }




    protected function rules(): array
    {


        return [
            'productStocks' => 'array',
            'productStocks.*' => 'numeric|min:0',
            'bottomStocksLimit'=>'numeric|min:0'
        ];
    }

    /*
    Custom messages for validation
    */
    protected $messages = [


        //Product stock validation messages
        'productStocks.*.numeric' => 'Količina artikala mora biti validan broj.',
        'productStocks.*.min' => 'Količina artikala mora biti pozitivan broj.',
        'bottomStocksLimit.numeric' => 'Količina artikala mora biti validan broj.',
        'bottomStocksLimit.min' => 'Količina artikala mora biti pozitivan broj.',

    ];

    //Main update stock method
    public function updateStock(): ?RedirectResponse
    {

        Gate::authorize('update', Product::class);
        
        $this->validate();
        DB::beginTransaction();
        try {
            //Getting user chosen stock elements
            foreach ($this->productStocks as $key => $stocksElements) {

                $stocks[] = $stocksElements;
            }

            $sum = array_sum($stocks); //Sum for total quantity column in products table

            foreach ($this->variantStocks  as $key =>  $stocksElements) {

                $categoryColorId = $stocksElements->category_color_id;
                $this->product->sizesVariant()->wherePivot('category_color_id', $categoryColorId)->updateExistingPivot($stocksElements->category_size_id, ['stock_quantity' =>   $stocks[$key]]);
            }

            
            //Inserting into product main table (general data). It is later used to show total quantity during product search.
            $this->product->update([

                'total_stock' => $sum,
                'bottom_stock_limit'=>$this->bottomStocksLimit,


            ]);

            DB::commit();

            return redirect()->back()->with("status", "Ažurirano...");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem tokom ažuriranja količine artikala. Molimo pokušajte ponovo.");
        }
    }

    //Function to remove the dark red background from low quantity inputs after the stock upate
    public function updatedProductstocks(): void
    {
        $this->toggle = true;
    }

    //Small method needed to be implemented to allow user to return to proper page after the update.
    public function backToProduct(): RedirectResponse|Redirector
    {

        $parameter = $this->requestRoute;
        $id = $this->requestId;
        if ($parameter == "update") {
            $url = route('editproduct', ['id' => $id]);
            return redirect()->to($url);
        } else if ($parameter == "search") {
            $url = route('products', ['id' => $id]);
            return redirect()->to($url);
        } else {

            $url = route('addproduct');
            return redirect()->to($url);
        }
    }


    public function render()
    {
        //To fix the n+1 problem caused by Livewire hydratation, we do this here instead of mount, and ommit the public variables
        $this->variantStocks = DB::table("products_variants")->where('product_id', $this->product->id)->get();
        $colors   = Color::findMany($this->variantStocks->pluck('category_color_id'));
        $sizes    = Size::findMany($this->variantStocks->pluck('category_size_id'));
        //Mapping colors to correct variant ids
        foreach ($this->variantStocks as $variant) {
            $color[] = $colors->firstWhere('id', $variant->category_color_id);
            $size[]  = $sizes->firstWhere('id', $variant->category_size_id);
            $this->productStocks[] = $variant->stock_quantity;
        }

        return view('livewire.add-product-stock', ["products" => $this->product, "images" => $this->images, "variantStocks" => $this->variantStocks, "color" => $color, "size" => $size]);
    }
}
