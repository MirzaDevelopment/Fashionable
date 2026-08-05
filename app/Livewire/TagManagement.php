<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically tag category management. It includes:
- Method to add new input fields for new tags.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert tag category method, with admin authorisation check.
- Method to delete category (soft delete).
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;


class TagManagement extends Component
{
    public array $tags = [''];


    // Method to add a new blank input field for another tag
    public function addTagInput(): void
    {
        $this->tags[] = '';
    }


    //Remove input
    public function removeTagInput(int $index): void
    {
        unset($this->tags[$index]);
    }

    //Validation
    protected function rules(): array
    {

        return [
            'tags' => 'required|array',
            'tags.*' => 'required|min:3|string|unique:category_tags,tag|regex:/^\p{L}+(?: \p{L}+)?$/u',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'tags.required' => 'Molimo unesite barem jednu oznaku.',
        'tags.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'tags.*.string' => 'Svaka oznaka mora biti ispravan tekst.',
        'tags.*.min' => 'Svaka oznaka mora sadržavati najmanje tri slova.',
        'tags.*.unique' => 'Otkriven je duplirani unos.',
        'tags.*.regex' => 'Oznaka smije sadržavati samo slova.',
    ];

    //Inserting category in db
    public function insertTag(): RedirectResponse
    {
        Gate::authorize('create', Tag::class);

                $this->validate();

                //Beginning transaction

                DB::beginTransaction();
                try {
                    foreach ($this->tags as $tags) {
                        Tag::create([
                            'source' => 'user',
                            'tag' => ucwords($tags),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Oznaka je dodana uspješno!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja oznaka. Molimo pokušaje ponovo.");
                }
            }
        
    


    // Method to delete category from db (soft method not used)

    public function deleteTagCategory(int $id, User $user): void
    {
        Gate::authorize('delete', Tag::class); //Authorisation for admin
        $tag = Tag::find($id);
        $tag->forceDelete();
    }

    //Method to reset input fields
    public function resetTag(): void
    {

        $this->reset('tags');
    }

    public function render()
    {
        $tags = Tag::all();
        return view('livewire.tag-management', ["tagsAll" => $tags]);
    }
}
