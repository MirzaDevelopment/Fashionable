<?php

namespace App\Livewire;

use Livewire\Component;

class AddQuestions extends Component
{

    public string $userName;
    private string $email;
    public string $question;
    public string $status;
    

    public function render()
    {
        return view('livewire.add-questions');
    }
}
