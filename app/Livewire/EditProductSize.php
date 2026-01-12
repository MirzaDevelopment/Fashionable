<?php
/*
This is a backend livewire component mostly used to edit product size categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product sizes, but also to get the selected colors ids, to upate the pivot table properly
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available size categories.
- Method to edit size categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current size for chosen product. Wrapped in transaction.
- Method to reset input fields.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Size;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EditProductSize extends Component
{
    public bool $isUploading = false;
    public int  $id;
    public object $activeColors;
    public array $activeColorIds=[];
    public array $activeSizes = [];
    #[Validate]
    public object $newProduct;
    public array $sizeSelect = [];
    public array $sizeDeSelect = [];
    public bool $toggle;

    public function mount():void
    {

    }

    /*
   Sizes select and edit
    */

    //Visual change of selected sizes
    public function SizeSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->sizeSelect)) {
            $index = array_search($parameter, $this->sizeSelect);
            unset($this->sizeSelect[$index]);
        } else {


            $this->sizeSelect[] = $parameter;
        }
    }

 //Visual change of deselected sizes
 public function SizeDeSelect(string $parameter):void
 {
     $this->toggle = false;
     $this->isUploading = false;
     if (in_array($parameter, $this->sizeDeSelect)) {
         $index = array_search($parameter, $this->sizeDeSelect);
         unset($this->sizeDeSelect[$index]);
     } else {


         $this->sizeDeSelect[] = $parameter;
     }
 }

//Edit product sizes
public function editSizes():?RedirectResponse
{

    if ($this->isUploading) {
        return null; // Prevent further submissions if already uploading
    }
     $this->newProduct = session("newProductModel");
        $this->activeColors = $this->newProduct->colors()->get();
        $this->activeSizes = $this->newProduct->sizesVariant()->get()->toArray();
        //Getting color ids for pivot table update
        foreach($this->activeColors as $colors){
         $this->activeColorIds[]=$colors->id;
        }
    foreach ($this->activeSizes as $sizeName) {


        $currentSizeArray[] = $sizeName["size"];
    }
  
        //to prevent updating without selecting at least one size category
        sort($this->sizeDeSelect);
        sort($currentSizeArray);
        if($this->sizeDeSelect==$currentSizeArray && empty($this->sizeSelect)){

            
        return session()->flash('emptySizes', 'Molimo odaberite barem jednu veličinu.');
        }
     Gate::authorize('create', Size::class);
    //Beginning transaction
    DB::beginTransaction();
    try {
        //Scenario one - admin choses extra categories while keeping original ones
        if (count(array_diff($this->sizeSelect, $currentSizeArray)) > 0) {
            $sizes = [($this->sizeSelect)];
           
            $resultsSizes = Size::whereIn('size', $sizes[0])->get();
            //Sorting sizes...
            $sortedResultsSizes = $resultsSizes->sortBy(function ($sizeArray) use ($sizes) {
                return array_search($sizeArray->size, $sizes[0]);  // Sort based on input array order
            });
            $idsSizes = $sortedResultsSizes->pluck('id')->toArray();
              //Final loop for adding ids in the product_variants pivot table
            foreach ($idsSizes as  $idsSizes) {
              
             $this->newProduct->colorsVariant()->attach($this->activeColorIds, ['category_size_id'=>  $idsSizes]);
               
            }
            
            //Small check to make sure user actually changes something in size panel
        } else if ((count(array_intersect($this->sizeDeSelect, $currentSizeArray)) == 0)) {

            return session()->flash('errorSizes', 'Odabrane veličine su već prisutne za ovaj proizvod');
        }

        //Scenario two - admin deletes original categories (soft deletes)
        $sizes = [($this->sizeDeSelect)];
        $resultsSizes = Size::whereIn('size', $sizes[0])->get();
        //Sorting sizes...
        $sortedResultsSizes = $resultsSizes->sortBy(function ($sizeArray) use ($sizes) {
            return array_search($sizeArray->size, $sizes[0]);  // Sort based on input array order
        });
        //...getting size id
        $idsSizes = $sortedResultsSizes->pluck('id')->toArray();
        $this->newProduct->sizesVariant()->detach($idsSizes);

        DB::commit();
        $this->isUploading = true;

        return redirect()->back()->with("status", "Veličine proizvoda su uspješno ažurirane.");
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction on error
        $this->isUploading = false;
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with("errorException", "Nastala je greška prilikom ažuriranja veličine proizvoda. Molimo pokušajte kasnije.");
    }
}

    public function render()
    {
        return view('livewire.edit-product-size');
    }
}
