<?php
/*
This is a backend livewire component mostly used to edit product prices and discounts. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current prices and discounts.
- Validation rules with corresponding messages.
- Helper method to unset date value if discount value changes
- Method to reset input(edit) fields.
- Main price edit method wrapped in transaction. 
- Method to reset input fields.
*/
namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Price;
use Illuminate\Support\Facades\Log;


class EditProductPrice extends Component
{
    public bool $isUploading = false;
    public object $newProduct;
    public ?object $newPrice;
    #[Validate]
    public float $productPrice;
    #[Validate]
    public ?float $productDiscount;
    #[Validate]
    public ?string $startDate=null;
    #[Validate]
    public  ?string $endDate=null;


    public function mount(Request $request):void
    {
        //Mostly important to show the admin current product data

        $this->newProduct = session("newProductModel");
        $this->newPrice = Price::where("product_id", $request->id)->first();
        $this->productPrice = $this->newPrice->price;
        $this->productDiscount = $this->newPrice->discount;
        $this->startDate = $this->newPrice->start_date;
        $this->endDate = $this->newPrice->end_date;

    }

       /*
    Validation
    */
    protected function rules():array
    {

        $rules = [

            'productPrice' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            //Product discount validation
            'productDiscount' => 'nullable|numeric|between:0,100|regex:/^\d+(\.\d{1,2})?$/',
            //Discount start and end date validation
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
        ];



        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [
        //Product name validation messages
       
        //Product Price validation messages
        'productPrice.required' => 'Starting product price is required.',
        'productPrice.numeric' => 'Product price must be a number.',
        'productPrice.regex' => 'The price must be a valid number with two decimal places (e.g., 25.45, 100.00).',
        'product_price.gt' => 'The price must be greater than 0.',
        //Product discount validation messages
        'productDiscount.numeric' => 'The discount must be a valid number.',
        'productDiscount.between' => 'The discount percentage must be between 0 and 100.',
        'productDiscount.regex' => 'The discount must be a valid number with up to two decimal places.',
        //Discount start and end date validation messages
        'startDate' => 'The provided discount start date is not valid.',
        'endDate' => 'The provided discount end date is not valid.',

    ];



    //Unsetting date if discount changed
    public function updatedproductDiscount():void
    {
        unset($this->endDate);
        unset($this->startDate);
    }

//Edit product price and discount
public function editPrice():?RedirectResponse
{

    if ($this->isUploading) {
        return null; // Prevent further submissions if already uploading
    }

     Gate::authorize('create', Price::class);
    $priceArray = ["productPrice", "productDiscount", "startDate", "endDate"];
    foreach ($priceArray as $validate) {
        $this->validateOnly($validate);
    }
    //Making sure both discount and dates are selected
    if (!(empty($this->productDiscount)) && empty($this->startDate) && empty($this->endDate)) {

        return session()->flash('errorDates', 'Please select start and end date for your discount!');
    }
    DB::beginTransaction();

    if (empty($this->productDiscount)) {
        $this->productDiscount = null;
    } 

    try {
        $this->newPrice->create([
            'product_id' => $this->newProduct->id,
            'price' => $this->productPrice,
            'discount' => $this->productDiscount = empty($this->productDiscount) ? null : $this->productDiscount,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,

        ]);
        //Soft deleting previous price
        Price::destroy($this->newPrice->id);


        DB::commit();
        $this->isUploading = true;
        return redirect()->back()->with("status", "Your price info updated successfully!");
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction on error
        $this->isUploading = false;
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with("errorException", "There was an issue updating the price info. Please try again.");
    }
}


    //Method to reset edit fields
    public function resetPrice():void
    {

        $this->reset([
            'productPrice', 'productDiscount',
            'startDate', 'endDate', 
        ]);
        $this->isUploading = false;
    }



    public function render()
    {
        return view('livewire.edit-product-price');
    }
}
