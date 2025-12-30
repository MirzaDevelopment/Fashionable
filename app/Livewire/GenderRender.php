<?php
/*
This is a backend livewire component used to render all the gender categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/

namespace App\Livewire;
use App\Models\Gender;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class GenderRender extends Component
{
    #[Reactive] 
    #[Lazy(isolate: false)] 
    public array $genderSelect = [];


    public function render()
    {
        $genders = Gender::all();
        return view('livewire.gender-render', ["gendersAll" => $genders]);
    }
}
