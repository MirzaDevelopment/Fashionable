<?php
/*
This is a backend class in livewire framework used for rendering the product tags on the first commercial page.

*/
namespace App\Livewire;
use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class TagCategoryFront extends Component
{
    #[Reactive]
    public array $tagSelect = [];
    public function render()
    {
        $tags = Tag::all();
        return view('livewire.tag-category-front', ["tagsAll" => $tags]);
    }
}
