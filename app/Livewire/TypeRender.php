<?php
/*
This is a backend livewire component used to render all the tag categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use App\Models\Type;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class TypeRender extends Component
{
    #[Reactive] 
    #[Lazy(isolate: false)]  
    public array $typeSelect = [];

    public function render()
    {
        $types = Type::all();
        return view('livewire.type-render', ["typesAll" => $types]);
    }
}
