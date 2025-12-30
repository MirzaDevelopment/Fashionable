<?php
/*
Livewire backend component used mostly for rendering the color categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the colors already present for chosen product($colorNames).
So the $colorNames array, will contain elements of already present colors in selected product.
This is a child component of the edit-product-color.blade.php, the frontend livewire component, used for editing product colors.
*/

namespace App\Livewire;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Reactive;
use App\Models\Color;
use Livewire\Component;
use Livewire\Attributes\Lazy;
class ColorEditRender extends Component
{


    #[Reactive]
    public array $colorSelect = [];
    #[Reactive]
    public array $colorDeSelect = [];
    #[Lazy(isolate: false)]
    public object $newProduct;
    public array|object $activeColors = [];
    public array $colorNames = [];
    public array $productImage = [];

    public function mount(): void
    {
       
        $this->newProduct =  session("newProductModel");
        $this->activeColors = Color::whereHas('products', function (Builder $query) {
        $query->where('products.id',  $this->newProduct->id);

})->get();

        foreach ($this->activeColors as $colors) {

            $this->colorNames[] = $colors->color;
        }
    }





    public function render()
    {
        $colors = Color::all();
        return view('livewire.color-edit-render', ["colorsAll" => $colors]);
    }
}
