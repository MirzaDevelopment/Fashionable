<?php
/*
This is a backend livewire component used to render all the heel categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use App\Models\Heel;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class HeelRender extends Component
{
    #[Reactive] 
    #[Lazy(isolate: false)] 
    public array $heelSelect = [];



    public function render()
    {
        $heels = Heel::all();
        return view('livewire.heel-render', ["heelsAll" => $heels]);
    }
}
