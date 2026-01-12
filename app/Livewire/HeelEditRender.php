<?php
/*
Livewire backend component used mostly for rendering the heel categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the heels already present for chosen product($heelNames).
So the $heelNames array, will contain elements of already present heels in selected product (low, high, platform etc..).
This is a child component of the edit-product-heel.blade.php, the frontend livewire component, used for editing product heel.
*/

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Models\Heel;
use Livewire\Attributes\Lazy;

class HeelEditRender extends Component
{

    #[Reactive]
    public array $heelSelect = [];
    #[Reactive]
    public array $heelDeSelect = [];
    #[Lazy(isolate: false)]
    public object $activeHeels;
    public array $heelNames = [];


    public function mount():void
    {
       
        $newProduct = session("newProductModel");
        $this->activeHeels = $newProduct->heel()->get();
        foreach ($this->activeHeels as $heels) {

            $this->heelNames[] = $heels->heel_type;
        }
    }




    public function render()
    {
    

        if (empty($this->heelNames)) {
            return view('livewire.heel-edit-render', ["emptyHeels" => "Kategorije štikle nisu prisutne kod ove vrste proizvoda"]);
        } else {
            $heels = Heel::with("product")->get();
            return view('livewire.heel-edit-render', ["heelsAll" => $heels]);
        }
    }
}
