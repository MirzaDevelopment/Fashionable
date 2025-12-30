<?php
/*
Livewire backend component used mostly for rendering the tag categories in edit product admin panel.
It's mount method is used to update the class properties (array) with the tags already present for chosen product($tagNames).
So the $tagNames array, will contain elements of already present tags in selected product (linen, wool, silk, suade etc..).
This is a child component of the edit-product-tag.blade.php, the frontend livewire component, used for editing product tags.
*/
namespace App\Livewire;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\Lazy;
class TagEditRender extends Component
{


    #[Reactive]
    public array $tagSelect = [];
    #[Reactive]
    public array $tagDeSelect = [];
    #[Lazy(isolate: false)]
    public object $activeTags;
    public array $tagNames = [];

    public function mount():void
    {
        
        $newProduct =  session("newProductModel");
        $this->activeTags = $newProduct->tags()->get();
        foreach ($this->activeTags as $tags) {

            $this->tagNames[] = $tags->tag;
        }
    }





    public function render()
    {
        $tags=Tag::all();
        return view('livewire.tag-edit-render', ["tagsAll"=>$tags]);
    }
}
