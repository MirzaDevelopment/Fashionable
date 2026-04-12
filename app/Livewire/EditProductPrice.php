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
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Price;
use App\Jobs\NotifyWishlistUsersAboutDiscount;
use Illuminate\Support\Facades\Log;


class EditProductPrice extends Component
{
    public bool $isUploading = false;
    public object $newProduct;
    public ?object $newPrice;
    public Carbon $currentDate;
    #[Validate]
    public float $productPrice;
    #[Validate]
    public ?float $productDiscount;
    #[Validate]
    public ?string $startDate = null;
    #[Validate]
    public  ?string $endDate = null;


    public function mount(Request $request): void
    {
        //Mostly important to show the admin current product data

        $this->newProduct = session("newProductModel");
        $this->newPrice = Price::where("product_id", $request->id)->first();
        $this->productPrice = $this->newPrice->price;
        $this->productDiscount = $this->newPrice->discount;
        $this->startDate = $this->newPrice->start_date;
        $this->endDate = $this->newPrice->end_date;
        $this->currentDate=Carbon::today();
    }

    /*
    Validation
    */
    protected function rules(): array
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

        // Product Price validation messages
        'productPrice.required' => 'Početna cijena proizvoda je obavezna.',
        'productPrice.numeric' => 'Cijena proizvoda mora biti broj.',
        'productPrice.regex' => 'Cijena mora biti ispravan broj sa dvije decimale (npr. 25.45, 100.00).',
        'product_price.gt' => 'Cijena mora biti veća od 0.',
        // Product discount validation messages
        'productDiscount.numeric' => 'Popust mora biti ispravan broj.',
        'productDiscount.between' => 'Procenat popusta mora biti između 0 i 100.',
        'productDiscount.regex' => 'Popust mora biti ispravan broj sa najviše dvije decimale.',
        // Discount start and end date validation messages
        'startDate' => 'Uneseni datum početka popusta nije ispravan.',
        'endDate' => 'Uneseni datum završetka popusta nije ispravan.',


    ];



    //Unsetting date if discount changed
    public function updatedproductDiscount(): void
    {
        unset($this->startDate);
        unset($this->endDate);
    }

    //Edit product price and discount
    public function editPrice(): ?RedirectResponse
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

            return session()->flash('errorDates', 'Molimo odaberite početni i kranji datum trajanja vašeg popusta.');
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
          //Dispatching event to send mail to users that wishlisted this product if discount changed.
            if (!(empty($this->productDiscount && $this->currentDate->between($this->startDate, $this->endDate)))) {
                NotifyWishlistUsersAboutDiscount::dispatch($this->newProduct->id);
            }
            // Invalidate the cache for the affected search result
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
            return redirect()->back()->with("status", "Informacije o cijenu su uspješno ažurirane.");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom ažuriranja podataka o cijeni. Molimo pokušajte ponovo.");
        }
    }


    //Method to reset edit fields
    public function resetPrice(): void
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
