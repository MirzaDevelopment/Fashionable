<?php
/*
This is a backend livewire component mostly used to edit product gender categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product genders.
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available gender categories.
- Method to edit gender categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current gender for chosen product. Wrapped in transaction.
*/
namespace App\Livewire;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Product;
use App\Models\Gender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EditProductGender extends Component
{
    public Product $product;
    public int $id;
    public bool $isUploading = false;
    public array $activeGenders = [];
    #[Validate]
    public object $newProduct;
    public array $genderSelect = [];
    public array $genderDeSelect = [];
    public bool $toggle;

    public function mount(Request $request):void
    {
        //Mostly important to show the admin current product data
        $this->id = $request->id;
        
       
    }


    /*
   Genders select and edit
    */



    //Visual change of selected genders
    public function GenderSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->genderSelect)) {
            $index = array_search($parameter, $this->genderSelect);
            unset($this->genderSelect[$index]);
        } else {


            $this->genderSelect[] = $parameter;
        }
    }

 //Visual change of deselected genders
 public function GenderDeSelect(string $parameter):void
 {
     $this->toggle = false;
     $this->isUploading = false;
     if (in_array($parameter, $this->genderDeSelect)) {
         $index = array_search($parameter, $this->genderDeSelect);
         unset($this->genderDeSelect[$index]);
     } else {


         $this->genderDeSelect[] = $parameter;
     }
 }
 //Edit product genders
 public function editGenders():?RedirectResponse
 {
     if ($this->isUploading) {
         return null; // Prevent further submissions if already uploading
     }
        $this->newProduct = session("newProductModel");

    $this->activeGenders = $this->newProduct->genders()->get()->toArray();
     foreach ($this->activeGenders as $genderName) {


         $currentGenderArray[] = $genderName["gender"];
     }
   
         //to prevent updating without selecting at least one gender category
         sort($this->genderDeSelect);
         sort($currentGenderArray);
         if($this->genderDeSelect==$currentGenderArray && empty($this->genderSelect)){

             
         return session()->flash('emptyGenders', 'Please select at least one gender category.');
         }
     Gate::authorize('create', Gender::class);
     //Beginning transaction
     DB::beginTransaction();
     try {
         //Scenario one - admin choses extra categories while keeping original ones
         if (count(array_diff($this->genderSelect, $currentGenderArray)) > 0) {
             $genders = [($this->genderSelect)];
             $resultsGenders = Gender::whereIn('gender', $genders[0])->get();
             //Sorting genders...
             $sortedResultsGenders = $resultsGenders->sortBy(function ($genderArray) use ($genders) {
                 return array_search($genderArray->gender, $genders[0]);  // Sort based on input array order
             });
             //...getting gender id
             $idsGenders = $sortedResultsGenders->pluck('id')->toArray();
             $this->newProduct->genders()->attach($idsGenders);
             //Small check to make sure user actually changes something in gender panel
         } else if ((count(array_intersect($this->genderDeSelect, $currentGenderArray)) == 0)) {

             return session()->flash('errorGenders', 'Genders already present for selected product');
         }

         //Scenario two - admin deletes original categories (soft deletes)
         $genders = [($this->genderDeSelect)];
         $resultsGenders = Gender::whereIn('gender', $genders[0])->get();
         //Sorting genders...
         $sortedResultsGenders = $resultsGenders->sortBy(function ($genderArray) use ($genders) {
             return array_search($genderArray->gender, $genders[0]);  // Sort based on input array order
         });
         //...getting gender id
         $idsGenders = $sortedResultsGenders->pluck('id')->toArray();
         $this->newProduct->genders()->detach($idsGenders);

         DB::commit();
         $this->isUploading = true;

         return redirect()->back()->with("status", "You edited product genders successfully!");
     } catch (\Exception $e) {
         DB::rollBack(); // Rollback the transaction on error
         $this->isUploading = false;
         Log::error('Error occurred: ' . $e->getMessage());
         return redirect()->back()->with("errorException", "There was an issue editing the product genders. Please try again.");
     }
 }

    public function render()
    {
        return view('livewire.edit-product-gender');
    }
}
