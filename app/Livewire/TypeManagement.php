<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically color category management. It includes:
- Method to add new input fields for new colors.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert color category method, with admin authorisation check.
- Method to delete category (soft delete).
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/
namespace App\Livewire;

use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TypeManagement extends Component
{

    public array $types = [''];

    // Method to add a new blank input field for another material
    public function addTypeInput():void
    {
        $this->types[] = '';
    }
    //Remove input
    public function removeTypeInput(int $index):void
    {
        unset($this->types[$index]);
    }
    //Validation
    protected function rules():array
    {

        return [
            'types' => 'required|array',
            'types.*' => 'required|min:3|string|unique:types,type_name|regex:/^[A-Za-z]+( [A-Za-z]+)?$/',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'types.required' => 'Please provide at least one clothing type.',
        'types.*.required' => 'Each added input must be filled.',
        'types.*.string' => 'Each clothing type must be a valid string.',
        'types.*.min' => 'Each clothing type must contain at least three letters.',
        'types.*.unique' => 'Duplicate entry detected.',
        'types.*.regex' => 'Clothing type must contain only letters.',
    ];

    //Inserting category in db
    public function insertType():RedirectResponse
    {
        Gate::authorize('create', Type::class);
        //Checking if type is already present but soft deleted (to prevent unique validation error)
        foreach ($this->types as $types) {

            if ($typesDeleted = Type::onlyTrashed()->where('type_name', $types)->first()) {
                $typesDeleted->restore();
                return redirect()->back()->with("status", "Product type added successfully!");
            } else {
                 //...if not, continue with regular insert
                $this->validate();
                //Beginning transaction
                
                DB::beginTransaction();
                try {
                    foreach ($this->types as $types) {
                        Type::create([
                            'type_name' => ucwords($types),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Product type added successfully!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "There was an issue adding type category. Please try again");
                }
            }
        }
    }


    // Method to delete category from db (soft method not used)
    public function deleteTypeCategory(int $id, User $user):void
    {
        Gate::authorize('delete', Type::class);; //Authorisation for admin
        $type = Type::find($id);
        $type->delete();
    }
    //Method to reset input fields
    public function resetType():void
    {

        $this->reset('types');
    }
    public function render()
    {
        $types = Type::all();
        return view('livewire.type-management', ["typesAll" => $types]);
    }
}
