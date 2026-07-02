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
        'userName.required' => 'Molimo unesite korisničko ime.',
        'userName.string' => 'Korisničko ime smije sadržavati samo slova.',
        'userName.min' => 'Korisničko ime mora sadržavati najmanje tri slova.',
        'userName.regex' => 'Korisničko ime smije sadržavati samo slova.',
        // Question body validation messages
        'question.required' => 'Molimo unesite komentar ili pitanje.',
        'question.string' => 'Pitanje mora biti u tekstualnom formatu.',
        'question.min' => 'Pitanje mora sadržavati najmanje 10 karaktera.',
        'question.max' => 'Pitanje ne smije prelaziti 1000 karaktera.',
        // Email validation messages
        'email.required' => 'Molimo unesite važeću email adresu kako bismo mogli odgovoriti što je prije moguće.',
        'email.email' => 'Molimo unesite ispravan format email adrese.',

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
                'user_email' => $this->email,
                'question' => $this->question,
                'status' => "neodgovoreno",
                

            ]);
            DB::commit();
            $this->userName = "";
            $this->email = "";
            $this->question = "";
            return redirect()->back()->with("status", "Poruka uspješno poslana. Odgovorićemo u najkraćem mogućem roku.");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem tokom slanja poruke. Molimo pokušajte ponovo.");
        }
    }

    public function render()
    {
        return view('livewire.add-questions');
    }
}
