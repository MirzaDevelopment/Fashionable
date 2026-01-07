<?php
/*
This is a backend livewire component for question upload by users on first product page.
It contains simple validation for user name, message/question body, and email
It also contains a simple question upload function, wrapped in transaction with sucessful or failed messages
*/
namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class AddQuestions extends Component
{
    #[Validate]
    public string $userName;
    #[Validate]
    public string $email;
    #[Validate]
    public string $question;
    public string $status;


    protected function rules(): array
    {

        $rules = [
            //Username validation
            'userName' => "required|min:3|string|regex:/^[\p{L}\s\']+$/u",
            //question validation
            'question' => 'required|string|min:10|max:1000',
            'email' => 'required|email'

        ];
        return $rules;
    }
    /*
        Custom messages for validation
    */
    protected $messages = [
        //User name validation messages
        'userName.required' => 'Please provide a user name.',
        'userName.string' => 'User name must contain only letters.',
        'userName.min' => 'User name must contain at least three letters.',
        'userName.regex' => 'User name name must contain only letters.',
        //Question body validation messages
        'question.required' => 'Please provide a comment or a question.',
        'question.string' => 'The question must be in text format.',
        'question.min' => 'The question must be at least 10 characters.',
        'question.max' => 'The question must not exceed 1000 characters.',
        //Email validation messages
        'email.required' => 'Please provide a valid email adress, so we can replay as soon as possible',
        'email.email' => 'Please provide a valid email adress format',

    ];

    public function uploadQuestion()
    {

        
        $this->validate();
         //Beginning transaction
        DB::beginTransaction();
        try {
            //Inserting into question main table;
            Question::create([
                'user_name' => ucfirst($this->userName),
                'user_email'=>$this->email,
                'question' => $this->question,
                'status' => "unanswered",
                'g-recaptcha-response' => 'required|recaptchav3:register,0.5'

            ]);
            DB::commit();
            $this->userName="";
            $this->email="";
            $this->question="";
            return redirect()->back()->with("status", "Message sent! We will respond to you shortly.");
             } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "There was an issue sending your message. Please try again later.");
        }
    }

    public function render()
    {
        return view('livewire.add-questions');
    }
}
