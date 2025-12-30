<?php
/*
This is a backend livewire component mostly used to edit product data specifically general info. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current general info values
- Validation rules with corresponding messages.
- Method to edit product general info wrapped in transaction.
- Method to reset input(edit) fields.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;


class EditProductGeneralInfo extends Component
{


    public bool $isUploading = false;
    public object $newProduct;
    #[Validate]
    public string $productName;
    #[Validate]
    public string $productDescription;



    public function mount(Request $request):void
    {
        //Mostly important to show the admin current product data
        $this->newProduct = Product::with("sizesVariant","colorsVariant")->find($request->id);
        //Making it available through other livewire components
        session(['newProductModel' => $this->newProduct]);
        $this->productName = $this->newProduct->product_name;
        $this->productDescription = $this->newProduct->description;

    }


    /*
    Validation
    */

    protected function rules():array
    {

        $rules = [
            //Product name validation
            'productName' => "required|min:3|string|regex:/^[A-Za-z\s']+( [A-Za-z\s']+)?$/",
            //Product description validation
            'productDescription' => 'required|string|min:10|max:1000',


        ];



        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [
        //Product name validation messages
        'productName.required' => 'Please provide a product name.',
        'productName.string' => 'Product name must contain only letters.',
        'productName.min' => 'Product name must contain at least three letters.',
        'productName.regex' => 'Product name must contain only letters.',
        //Product description validation messages
        'productDescription.required' => 'Please provide a product description.',
        'productDescription.string' => 'Product name must be valid string.',
        'productDescription.min' => 'The product description must be at least 10 characters.',
        'productDescription.max' => 'The product description must not exceed 1000 characters.',


    ];

    //Edit product general info
    public function editProduct():?RedirectResponse
    {

        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }

        Gate::authorize('update', Product::class);
        $generalInfoArray = ["productName", "productDescription"];
        foreach ($generalInfoArray as $validate) {
            $this->validateOnly($validate);
        }
        DB::beginTransaction();
        try {
            $this->newProduct->update([
                'product_name' => $this->productName,
                'description' => $this->productDescription,


            ]);


            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("status", "Your product info updated successfully!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "There was an issue updating the product info. Please try again.");
        }
    }



    //Method to reset edit fields
    public function resetGeneralInfo():void
    {

        $this->reset([
            'productName', 'productDescription'
        ]);
        $this->isUploading = false;
    }







    public function render()
    {
        return view('livewire.edit-product-general-info');
    }
}
