<?php
/*
This is a livewire backend component used for rendering questions/comments that users send from first page.
It contains methods to delete the question, and/or to update question status to "answered".
It also has the method, to directly send the replay through the mail user entered in the form.
Finally it has the render method to render the questions mentioned in to the show-questions view.
*/

namespace App\Livewire;

use Illuminate\Support\Facades\Mail; //Za slanje maila
use App\Mail\QuestionReplies;
use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;

class ShowQuestions extends Component
{

    use WithPagination;
    public string $sortinator = "created_at";
    public string $sortToggle = "DESC";
    public array $replyArea;
    public array $replySuccess = [];
    public array $replyFailed = [];

    //Deleting a question 
    public function deleteQuestion(string $parameter): void
    {

        Gate::authorize('delete', Question::class);
        Question::destroy($parameter);
    }

    //Changing status to "answered" and vice versa
    public function updateQuestion(string $parameter): void
    {

        Gate::authorize('update', Question::class);

        $question = Question::find($parameter);
        if ($question->status == "neodgovoreno") {
            $question->update([
                'status' => "odgovoreno",



            ]);
        } else {
            $question->update([
                'status' => "neodgovoreno",



            ]);
        }
    }


    public function sendQuestionReply($parameter)
    {
        if (count($this->replyArea) == 1) {
            $question = Question::find($parameter);

            Mail::to($question->user_email)->send(new QuestionReplies($question, $this->replyArea));
            $question->update([
                'status' => "odgovoreno",



            ]);
            $this->replySuccess[$parameter] = 'Mail je uspješno poslan korisniku!';
        } else {
            $this->replyFailed[$parameter] = 'Nešto je pošlo po zlu, molimo osvježite stranicu i pokušajte ponovo.';
        }
    }

    public function render()
    {

        $questions = Question::orderBy($this->sortinator, $this->sortToggle)->paginate(15);

        return view('livewire.show-questions', ["questions" => $questions]);
    }
}
