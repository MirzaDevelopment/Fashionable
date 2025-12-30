<?php
/*
This is a backend livewire component mostly used to edit product heel categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product heels.
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available heel categories.
- Method to edit heel categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current heel for chosen product. Wrapped in transaction.
- Method to reset input fields.
A single product can have only a single HEEL category (ex. platform, stilleto, low, flat etc...)
Selecting more will result in an error and prevent product update.
*/
namespace App\Livewire;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Heel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
class EditProductHeel extends Component
{

    public bool $isUploading = false;
    public int  $id;
    public array $activeHeels = [];
    #[Validate]
    public object $newProduct;
    public array $heelSelect = [];
    public array $heelDeSelect = [];
    public bool $toggle;

    public function mount(Request $request):void
    {
        //Mostly important to show the admin current product data
     $this->id = $request->id;
       
    }



    /*
   Heel select and edit
    */


    //Visual change of selected heels
    public function HeelSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->heelSelect)) {
            $index = array_search($parameter, $this->heelSelect);
            unset($this->heelSelect[$index]);
        } else {

            //Since only one heel can be selected, this will prevent users to pick more. Message will also be displayed to user(admin)
            $this->heelSelect[] = $parameter;
            if (count(($this->heelSelect)) > 1) {
                array_pop($this->heelSelect);
               session()->flash('errorHeel', 'Please select only one NEW product heel type!');
               
            }
        }
    }

    //Visual change of deselected heels
    public function HeelDeSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->heelDeSelect)) {
            $index = array_search($parameter, $this->heelDeSelect);
            unset($this->heelDeSelect[$index]);
        } else {


            $this->heelDeSelect[] = $parameter;
        }
    }

 //Edit product heels
 public function editHeels():?RedirectResponse
 {
     if ($this->isUploading) {
         return null; // Prevent further submissions if already uploading
     }
     $this->newProduct = session("newProductModel");
    
      $this->activeHeels = $this->newProduct->heel()->get()->toArray();
    
     foreach ($this->activeHeels as $heelName) {


         $currentHeelArray[] = $heelName["heel_type"];
        }

     //to prevent updating without selecting at least one heel category
     sort($this->heelDeSelect);
     sort($currentHeelArray);
     if ($this->heelDeSelect == $currentHeelArray && empty($this->heelSelect)) {


         return session()->flash('emptyHeels', 'Please select at least one heel category.');
     }
     Gate::authorize('update', Heel::class);
     //Beginning transaction
     DB::beginTransaction();
     try {
         //Scenario one - admin choses extra categories while keeping original ones
         if (count(array_diff($this->heelSelect, $currentHeelArray)) > 0) {
             $heels = [($this->heelSelect)];
             $resultsHeels = Heel::whereIn('heel_type', $heels[0])->get();
             //Sorting heels...
             $sortedResultsHeels = $resultsHeels->sortBy(function ($heelArray) use ($heels) {
                 return array_search($heelArray->heel, $heels[0]);  // Sort based on input array order
             });
             //...getting heel id
             $idsHeels = $sortedResultsHeels->pluck('id')->toArray();

             $this->newProduct->update([
                 'heel_id' => $idsHeels[0],



             ]);

             //Small check to make sure user actually changes something in heel panel
         } else if ((count(array_intersect($this->heelDeSelect, $currentHeelArray)) == 0)) {

             return session()->flash('errorHeels', 'Heels already present for selected product');
         }



         DB::commit();
         $this->isUploading = true;

         return redirect()->back()->with("status", "You edited product heels successfully!");
     } catch (\Exception $e) {
         DB::rollBack(); // Rollback the transaction on error
         $this->isUploading = false;
         Log::error('Error occurred: ' . $e->getMessage());
         return redirect()->back()->with("errorException", "There was an issue editing the product heels. Please try again.");
     }
 }






    public function render()
    {
        return view('livewire.edit-product-heel');
    }
}
