<?php
/*
This is a livewire backend component used for rendering questions/comments that users send from first page.
Its a simple component, that has the render method to render the questions mentioned in to the show-questions view.
*/
namespace App\Livewire;
use App\Models\Question;
use Livewire\Component;

class ShowQuestions extends Component
{




    public function render()
    {

        $questions=Question::all();
        return view('livewire.show-questions', ["questions"=>$questions]);
    }
}
