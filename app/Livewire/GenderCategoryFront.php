<?php
/*
This is a backend class in livewire framework used for rendering the product genders on the first commercial page. It includes:


    
*/

namespace App\Livewire;

use App\Models\Gender;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class GenderCategoryFront extends Component
{
    #[Reactive]
    public array $genderSelect=[];

    public function render()
    {
        $genders = Gender::all();
        return view('livewire.gender-category-front', ["gendersAll" => $genders]);
    }
}
