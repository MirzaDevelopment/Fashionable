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
use Illuminate\Support\Facades\Cache;
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



    public function mount(Request $request): void
    {
        //Mostly important to show the admin current product data
        $this->newProduct = Product::with("sizesVariant", "colorsVariant")->find($request->id);
        //Making it available through other livewire components
        session(['newProductModel' => $this->newProduct]);
        $this->productName = $this->newProduct->product_name;
        $this->productDescription = $this->newProduct->description;
    }


    /*
    Validation
    */

    protected function rules(): array
    {

        $rules = [
            //Product name validation
            'productName' => "required|min:3|string|regex:/^[\p{L}\s']+( [\p{L}\s']+)?$/u",
            //Product description validation
            'productDescription' => 'required|string|min:10|max:1000',


        ];



        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [
        'productName.required' => 'Molimo unesite naziv proizvoda.',
        'productName.string' => 'Naziv proizvoda smije sadržavati samo slova.',
        'productName.min' => 'Naziv proizvoda mora sadržavati najmanje tri slova.',
        'productName.regex' => 'Naziv proizvoda smije sadržavati samo slova.',
        // Product description validation messages
        'productDescription.required' => 'Molimo unesite opis proizvoda.',
        'productDescription.string' => 'Opis proizvoda mora biti ispravan tekst.',
        'productDescription.min' => 'Opis proizvoda mora imati najmanje 10 karaktera.',
        'productDescription.max' => 'Opis proizvoda ne smije prelaziti 1000 karaktera.',


    ];

    //Edit product general info
    public function editProduct(): ?RedirectResponse
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

            Cache::forget('search_' . md5(
                $this->search .
                    $this->sortinator .
                    $this->sortToggle .
                    implode(',', $this->genderSelect) .
                    implode(',', $this->tagSelect) .
                    $this->typeSelect
            ));
            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("status", "Podaci o proizvodu su uspješno ažurirani!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom ažuriranja podataka o proizvodu. Molimo pokušajte ponovo.");
        }
    }



    //Method to reset edit fields
    public function resetGeneralInfo(): void
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
