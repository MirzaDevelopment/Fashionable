<?php
/*
This is a backend class in livewire framework used for rendering the product types on the first commercial page.
*/

namespace App\Livewire;

use Livewire\Component;
use App\Models\Type;
use Livewire\Attributes\Reactive;

class TypeCategoryFront extends Component
{
    #[Reactive]
    public string $typeSelect;
    #[Reactive]
    public array $selectedTypesContainer=[];//Container array used to store selected items for better visual clarity

    public function render()
    {
        $types = Type::all();
        return view('livewire.type-category-front', ["typesAll" => $types]);
    }
}
