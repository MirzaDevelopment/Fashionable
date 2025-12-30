<?php
/*
This is a backend livewire component used to render all the tag categories available in database.
It is used mostly in upload product admin panel, as a child component.
*/
namespace App\Livewire;
use App\Models\Tag;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Attributes\Lazy;

class TagRender extends Component
{

    #[Reactive] 
    #[Lazy(isolate: false)] 
    public array $tagSelect = [];


    public function render()
    {
        $tags = Tag::all();
        return view('livewire.tag-render', ["tagsAll"=>$tags]);
    }
}
