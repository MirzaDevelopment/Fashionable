<?php
/*
Livewire backend component used mostly for rendering the size categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the sizes already present for chosen product($sizeNames).
So the $sizeNames array, will contain elements of already present sizes in selected product (linen, wool, silk, suade etc..).
This is a child component of the edit-product-size.blade.php, the frontend livewire component, used for editing product sizes.
*/

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use App\Models\Size;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class SizeEditRender extends Component
{


    #[Reactive]
    public array $sizeSelect = [];
    #[Reactive]
    public array $sizeDeSelect = [];
    #[Lazy(isolate: false)]
    public object $activeSizes;
    public array $sizeNames = [];
    public array $sizeTypes;

    public function mount():void
    {
        
        $newProduct =  session("newProductModel");
        $this->activeSizes = $newProduct->sizesVariant()->get();
        foreach ($this->activeSizes as $sizes) {

            $this->sizeNames[] = $sizes->size;
            $this->sizeTypes[]=$sizes->size_type;
        }
    }




    public function render()
    {
        $sizes = Size::where("size_type", $this->sizeTypes)->get();
        return view('livewire.size-edit-render', ["sizesAll" => $sizes]);
    }
}
