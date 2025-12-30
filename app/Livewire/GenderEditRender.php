<?php
/*
Livewire backend component used mostly for rendering the gender categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the genders already present for chosen product($genderNames).
So the $genderNames array, will contain elements of already present genders in selected product (male, female,etc..).
This is a child component of the edit-product-gender.blade.php, the frontend livewire component, used for editing product genders.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use App\Models\Gender;
use Livewire\Component;
use Livewire\Attributes\Lazy;
class GenderEditRender extends Component
{

    #[Reactive] 
    public array $genderSelect = [];
    #[Reactive] 
    public array $genderDeSelect= [];
    #[Lazy(isolate: false)] 
    public object $activeGenders;
    public array $genderNames=[];

    public function mount ():void
    {
        
        $newProduct = session("newProductModel");
        $this->activeGenders=$newProduct->genders()->get();
        foreach ($this->activeGenders as $genders){

           $this->genderNames[]=$genders->gender;

        }

       
    }



    public function render()
    {
        $genders= Gender::all();
        return view('livewire.gender-edit-render',["gendersAll" => $genders]);
    }
}
