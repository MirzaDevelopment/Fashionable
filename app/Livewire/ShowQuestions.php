<?php
/*
This is a livewire backend component used for rendering questions/comments that users send from first page.
Its a simple component, that has the render method to render the questions mentioned in to the show-questions view.
*/
namespace App\Livewire;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;
class ShowQuestions extends Component
{

    use WithPagination;
    public string $sortinator="created_at"; 
    public string $sortToggle="DESC";

    public function render()
    {

        $questions=Question::orderBy($this->sortinator, $this->sortToggle)->paginate(15);

        return view('livewire.show-questions', ["questions"=>$questions]);
    }
}
