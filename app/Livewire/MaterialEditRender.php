<?php
/*
Livewire backend component used mostly for rendering the material categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the materials already present for chosen product($materialNames).
So the $materialNames array, will contain elements of already present materials in selected product (linen, wool, silk, suade etc..).
This is a child component of the edit-product-material.blade.php, the frontend livewire component, used for editing product materials.
*/

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use App\Models\Material;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\Attributes\Lazy;

class MaterialEditRender extends Component
{

    #[Reactive]
    public array $materialSelect = [];
    #[Reactive]
    public array $materialDeSelect = [];
    #[Lazy(isolate: false)]
    public object $activeMaterials;
    public array $materialNames = [];
    public object $newProduct;
    public function mount(Request $request): void
    {
        if ($request->id) {
            $this->newProduct = session("newProductModel");
            $this->activeMaterials = $this->newProduct->materials()->get();
            foreach ($this->activeMaterials as $materials) {

                $this->materialNames[] = $materials->material;
            }
        } else {
            return;
        }
    }



    public function render()
    {
        $materials = Material::all();
        return view('livewire.material-edit-render', ["materialsAll" => $materials]);
    }
}
