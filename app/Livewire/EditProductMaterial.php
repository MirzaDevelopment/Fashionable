<?php
/*
This is a backend livewire component mostly used to edit product material categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product materials.
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available material categories.
- Method to edit material categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current material for chosen product. Wrapped in transaction.
- Method to reset input fields.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EditProductMaterial extends Component
{

    public bool $isUploading = false;
    public int  $id;
    public array $activeMaterials = [];
    public array $currentMaterialArray = [];
    #[Validate]
    public object $newProduct;
    public array $materialSelect = [];
    public array $materialDeSelect = [];
    public bool $toggle;

    public function mount(): void
    {

    }


    /*
    Materials select and edit
    */

    //Visual change of selected materials
    public function MaterialSelect(string $parameter): void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->materialSelect)) {
            $index = array_search($parameter, $this->materialSelect);
            unset($this->materialSelect[$index]);
        } else {


            $this->materialSelect[] = $parameter;
        }
    }
    //Visual change of deselected materials
    public function MaterialDeSelect(string $parameter)
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->materialDeSelect)) {
            $index = array_search($parameter, $this->materialDeSelect);
            unset($this->materialDeSelect[$index]);
        } else {


            $this->materialDeSelect[] = $parameter;
        }
    }

    //Edit product materials
    public function editMaterials(): ?RedirectResponse
    {
         Gate::authorize('create', Material::class);
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }
        $this->newProduct = session("newProductModel");
        $this->activeMaterials = $this->newProduct->materials()->get()->toArray();
        foreach ($this->activeMaterials as $materialName) {


            $this->currentMaterialArray[] = $materialName["material"];
        }
        //to prevent updating without selecting at least one material category
        sort($this->materialDeSelect);
        sort($this->currentMaterialArray);
        if ($this->materialDeSelect == $this->currentMaterialArray && empty($this->materialSelect)) {


            return session()->flash('emptyMaterials', 'Please select at least one material category.');
        }

        //Beginning transaction
        DB::beginTransaction();
        try {
            //Scenario one - admin choses extra categories while keeping original ones
            if (count(array_diff($this->materialSelect, $this->currentMaterialArray)) > 0) {
                $materials = [($this->materialSelect)];
                $resultsMaterials = Material::whereIn('material', $materials[0])->get();
                //Sorting materials...
                $sortedResultsMaterials = $resultsMaterials->sortBy(function ($materialArray) use ($materials) {
                    return array_search($materialArray->material, $materials[0]);  // Sort based on input array order
                });
                //...getting material id
                $idsMaterials = $sortedResultsMaterials->pluck('id')->toArray();
           
                $this->newProduct->materials()->attach($idsMaterials);
                //Small check to make sure user actually changes something in material panel
            } else if ((count(array_intersect($this->materialDeSelect, $this->currentMaterialArray)) == 0)) {

                return session()->flash('errorMaterials', 'Materials already present for selected product');
            }

            //Scenario two - admin deletes original categories (soft deletes)
            $materials = [($this->materialDeSelect)];
            $resultsMaterials = Material::whereIn('material', $materials[0])->get();
            //Sorting materials...
            $sortedResultsMaterials = $resultsMaterials->sortBy(function ($materialArray) use ($materials) {
                return array_search($materialArray->material, $materials[0]);  // Sort based on input array order
            });
            //...getting material id
            $idsMaterials = $sortedResultsMaterials->pluck('id')->toArray();
            $this->newProduct->materials()->detach($idsMaterials);

            DB::commit();
            $this->isUploading = true;

            return redirect()->back()->with("status", "You edited product materials successfully!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "There was an issue editing the product materials. Please try again.");
        }
    }
    //Method to reset edit fields
    public function resetProduct(): void
    {

        $this->reset([
            'materialSelect',

        ]);
        $this->isUploading = false;
    }



    public function render()
    {
        return view('livewire.edit-product-material');
    }
}
