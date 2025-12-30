<?php
/*
This is a backend livewire component used to render all the size categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use App\Models\Size;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class SizeRender extends Component
{
    #[Reactive] 
    #[Lazy(isolate: false)]  
    public array $sizeSelect = [];


    public function render()
    {
        $sizes = Size::all();
        return view('livewire.size-render', ["sizesAll" => $sizes]);
    }
}
