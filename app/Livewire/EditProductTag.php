<?php
/*
This is a backend livewire component mostly used to edit product tag categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product tags.
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available tag categories.
- Method to edit tag categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current tag for chosen product. Wrapped in transaction.
- Method to reset input fields.
*/

namespace App\Livewire;
use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
class EditProductTag extends Component
{


    public bool $isUploading = false;
    public array $activeTags = [];
    #[Validate]
    public object $newProduct;
    public array $tagSelect = [];
    public array $tagDeSelect = [];
    public bool $toggle;


    public function mount():void
    {
     
    }



   /*
   Tags select and edit
    */



    //Visual change of selected tags
    public function TagSelect(string $parameter):void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->tagSelect)) {
            $index = array_search($parameter, $this->tagSelect);
            unset($this->tagSelect[$index]);
        } else {


            $this->tagSelect[] = $parameter;
        }
    }

     //Visual change of deselected tags
 public function TagDeSelect(string $parameter):void
 {
     $this->toggle = false;
     $this->isUploading = false;
     if (in_array($parameter, $this->tagDeSelect)) {
         $index = array_search($parameter, $this->tagDeSelect);
         unset($this->tagDeSelect[$index]);
     } else {


         $this->tagDeSelect[] = $parameter;
     }
 }

 //Edit product tags
public function editTags():?RedirectResponse
{
    if ($this->isUploading) {
        return null; // Prevent further submissions if already uploading
    }
    $this->newProduct = session("newProductModel");
  $this->activeTags = $this->newProduct->tags()->get()->toArray();
   
    foreach ($this->activeTags as $tagName) {


        $currentTagArray[] = $tagName["tag"];
    }
  
        //to prevent updating without selecting at least one tagcategory
        sort($this->tagDeSelect);
        sort($currentTagArray);
        if($this->tagDeSelect==$currentTagArray && empty($this->tagSelect)){

            
        return session()->flash('emptyTags', 'Molimo odaberite barem jednu oznaku za proizvod');
        }
    Gate::authorize('create', Tag::class);
    //Beginning transaction
    DB::beginTransaction();
    try {
        //Scenario one - admin choses extra categories while keeping original ones
        if (count(array_diff($this->tagSelect, $currentTagArray)) > 0) {
            $tags = [($this->tagSelect)];
            $resultsTags = Tag::whereIn('tag', $tags[0])->get();
            //Sorting tags...
            $sortedResultsTags = $resultsTags->sortBy(function ($tagArray) use ($tags) {
                return array_search($tagArray->tag, $tags[0]);  // Sort based on input array order
            });
            //...getting tag id
            $idsTags = $sortedResultsTags->pluck('id')->toArray();
            $this->newProduct->tags()->attach($idsTags);
            //Small check to make sure user actually changes something in tag panel
        } else if ((count(array_intersect($this->tagDeSelect, $currentTagArray)) == 0)) {

            return session()->flash('errorTags', 'Odabrana oznaka je već prisutan za ovaj proizvod.');
        }

        //Scenario two - admin deletes original categories (soft deletes)
        $tags = [($this->tagDeSelect)];
        $resultsTags = Tag::whereIn('tag', $tags[0])->get();
        //Sorting tags...
        $sortedResultsTags = $resultsTags->sortBy(function ($tagArray) use ($tags) {
            return array_search($tagArray->tag, $tags[0]);  // Sort based on input array order
        });
        //...getting tag id
        $idsTags = $sortedResultsTags->pluck('id')->toArray();
        $this->newProduct->tags()->detach($idsTags);

        DB::commit();
        $this->isUploading = true;

        return redirect()->back()->with("status", "Uspješno ste ažurirali oznake za ovaj proizvod");
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction on error
        $this->isUploading = false;
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with("errorException", "Nastao je problem prilikom ažuriranja oznaka. Molimo pokušajte ponovo.");
    }
}

    public function render()
    {
        return view('livewire.edit-product-tag');
    }
}
