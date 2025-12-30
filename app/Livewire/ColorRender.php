<?php
/*
This is a backend livewire component used to render all the color categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use App\Models\Color;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class ColorRender extends Component
{
    #[Reactive]
    #[Lazy(isolate: false)]
    public array $colorSelect = [];


    public function render()
    {
        $colors = Color::all();
        return view('livewire.color-render', ["colorsAll" => $colors]);
    }
}
