<?php
/*
Livewire backend component used mostly for rendering the type categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the types already present for chosen product($typeNames).
So the $typeNames array, will contain elements of already present types in selected product (linen, wool, silk, suade etc..).
This is a child component of the edit-product-type.blade.php, the frontend livewire component, used for editing product type.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Models\Type;
use Livewire\Attributes\Lazy;
class TypeEditRender extends Component
{


    #[Reactive]
    public array $typeSelect = [];
    #[Reactive]
    public array $typeDeSelect = [];
    #[Lazy(isolate: false)]
    public object $activeTypes;
    public array $typeNames = [];

    public function mount():void
    {
       
        $newProduct = session("newProductModel");
        $this->activeTypes = $newProduct->type()->get();
        foreach ($this->activeTypes as $types) {

            $this->typeNames[] = $types->type_name;
            
        }
    }



    public function render()
    {
        $types=Type::all();
        return view('livewire.type-edit-render', ["typesAll"=>$types]);
    }
}
