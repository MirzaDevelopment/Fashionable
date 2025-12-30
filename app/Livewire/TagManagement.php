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
    public function addTagInput():void
    {
        $this->tags[] = '';
    }


    //Remove input
    public function removeTagInput(int $index):void
    {
        unset($this->tags[$index]);
    }

    //Validation
    protected function rules():array
    {

        return [
            'tags' => 'required|array',
            'tags.*' => 'required|min:3|string|unique:category_tags,tag|regex:/^[A-Za-z]+( [A-Za-z]+)?$/',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'tags.required' => 'Please provide at least one tag type.',
        'tags.*.required' => 'Each added input must be filled.',
        'tags.*.string' => 'Each tag must be a valid string.',
        'tags.*.min' => 'Each tag must be contain at least three letters.',
        'tags.*.unique' => 'Duplicate entry detected.',
        'tags.*.regex' => 'Tag must contain only letters.',
    ];

    //Inserting category in db
    public function insertTag():RedirectResponse
    {
        Gate::authorize('create', Tag::class);
        //Checking if tag is already present but soft deleted (to prevent unique validation error)
        foreach ($this->tags as $tags) {
            if ($tagsDeleted = Tag::onlyTrashed()->where('tag', $tags)->first()) {
                $tagsDeleted->restore();
                return redirect()->back()->with("status", "Tag added successfully!");
            } else {
                //...if not, continue with regular insert

                $this->validate();

                //Beginning transaction
                
                DB::beginTransaction();
                try {
                    foreach ($this->tags as $tags) {
                        Tag::create([
                            'tag' => ucwords($tags),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Tag added successfully!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "There was an issue adding tag. Please try again");
                }
            }
        }
    }


    // Method to delete category from db (soft method not used)

    public function deleteTagCategory(int $id, User $user):void
    {
        Gate::authorize('delete', Tag::class); //Authorisation for admin
        $tag = Tag::find($id);
        $tag->delete();
    }

    //Method to reset input fields
    public function resetTag():void
    {

        $this->reset('tags');
    }

    public function render()
    {
        $tags = Tag::all();
        return view('livewire.tag-management', ["tagsAll" => $tags]);
    }
}
