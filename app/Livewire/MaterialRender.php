<?php
/*
This is a backend livewire component used to render all the material categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class MaterialRender extends Component
{
    #[Reactive] 
    #[Lazy(isolate: false)] 
    public array $materialSelect = [];

    public function render()
    {
        $materials = Material::all();
        return view('livewire.material-render', ["materialsAll" => $materials]);
    }
}
