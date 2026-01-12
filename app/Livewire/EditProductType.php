<?php
/*
This is a backend livewire component mostly used to edit product type categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product types.
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available type categories.
- Method to edit type categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current type for chosen product. Wrapped in transaction.
- Method to reset input fields.
A single product can have only a single TYPE category (ex. scarf, boot, jeans, dress etc...)
Selecting more and updating the product, will result in an error.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use App\Models\Type;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EditProductType extends Component
{


    public bool $isUploading = false;
    public array $activeTypes = [];
    #[Validate]
    public object $newProduct;
    public array $typeSelect = [];
    public array $typeDeSelect = [];
    public bool $toggle;



    public function mount():void
    {
       
        
    }


    /*
   Type select and edit
    */

    //Visual change of selected types
    public function TypeSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->typeSelect)) {
            $index = array_search($parameter, $this->typeSelect);
            unset($this->typeSelect[$index]);
        } else {

            //Since only one type can be selected, this will prevent users to pick more. Message will also be displayed to user(admin)
            $this->typeSelect[] = $parameter;
            if (count(($this->typeSelect)) > 1) {
                array_pop($this->typeSelect);
                session()->flash('errorType', 'Molimo odaberite SAMO JEDNU novu vrstu proizvoda');
            }
        }
    }

    //Visual change of deselected types
    public function TypeDeSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->typeDeSelect)) {
            $index = array_search($parameter, $this->typeDeSelect);
            unset($this->typeDeSelect[$index]);
        } else {


            $this->typeDeSelect[] = $parameter;
        }
    }

    //Edit product types
    public function editTypes():?RedirectResponse
    {
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }
        $this->newProduct = session("newProductModel");
        $this->activeTypes = $this->newProduct->type()->get()->toArray();
        foreach ($this->activeTypes as $typeName) {


            $currentTypeArray[] = $typeName["type_name"];
        }

        //to prevent updating without selecting at least one type category
        sort($this->typeDeSelect);
        sort($currentTypeArray);
        if ($this->typeDeSelect == $currentTypeArray && empty($this->typeSelect)) {


            return session()->flash('emptyTypes', 'Molimo odaberite barem jednu vrstu proizvoda');
        }
         Gate::authorize('update', Type::class);
        //Beginning transaction
        DB::beginTransaction();
        try {
            //Scenario one - admin choses extra categories while keeping original ones
            if (count(array_diff($this->typeSelect, $currentTypeArray)) > 0) {
                $types = [($this->typeSelect)];
                $resultsTypes = Type::whereIn('type_name', $types[0])->get();
                //Sorting typess...
                $sortedResultsTypes = $resultsTypes->sortBy(function ($typeArray) use ($types) {
                    return array_search($typeArray->type, $types[0]);  // Sort based on input array order
                });
                //...getting type id
                $idsTypes = $sortedResultsTypes->pluck('id')->toArray();
                //...Updating
                $this->newProduct->update([
                    'type_id' => $idsTypes[0],



                ]);

                //Small check to make sure user actually changes something in type panel
            } else if ((count(array_intersect($this->typeDeSelect, $currentTypeArray)) == 0)) {

                return session()->flash('errorTypes', 'Odabrana vrsta proizvoda je već prisutna kod ovog proizvoda');
            }



            DB::commit();
            $this->isUploading = true;

            return redirect()->back()->with("status", "Uspješno ste ažurirali vrstu proizvoda.");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom ažuriranja vrste proizvoda. Molimo pokušajte ponovo.");
        }
    }



    public function render()
    {
        return view('livewire.edit-product-type');
    }
}
