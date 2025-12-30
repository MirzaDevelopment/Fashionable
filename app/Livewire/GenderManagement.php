<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically gender management. It includes:
- Method to add new input fields for new genders.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert gender category method, with admin authorisation check.
- Method to delete category (soft delete).
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/
namespace App\Livewire;

use App\Models\Gender;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class GenderManagement extends Component
{


    public array $genders = [''];

    // Method to add a new blank input field for another gender
    public function addGenderInput():void
    {
        $this->genders[] = '';
    }

    //Remove input
    public function removeGenderInput(string $index):void
    {
        unset($this->genders[$index]);
    }
    //Validation
    protected function rules():array
    {

        return [
            'genders' => 'required|array',
            'genders.*' => 'required|min:3|string|unique:category_genders,gender|regex:/^[A-Za-z]+( [A-Za-z]+)?$/',

        ];
    }
    //Custom messages for validation
    protected $messages = [
        'genders.required' => 'Please provide at least one gender type.',
        'genders.*.required' => 'Each added input must be filled.',
        'genders.*.string' => 'Each gender must be a valid string.',
        'genders.*.min' => 'Each gender must be contain at least three letters.',
        'genders.*.unique' => 'Duplicate entry detected.',
        'genders.*.regex' => 'Gender must contain only letters.',
    ];

    //Inserting category in db
    public function insertGender():RedirectResponse
    {
        Gate::authorize('create', Gender::class);
        //Checking if gender is already present but soft deleted (to prevent unique validation error)
        foreach ($this->genders as $genders) {
            if ($gendersDeleted = Gender::onlyTrashed()->where('gender', $genders)->first()) {
                $gendersDeleted->restore();
                return redirect()->back()->with("status", "Gender types added successfully!");
            } else {
                //...if not, continue with regular insert
                $this->validate();
                
                //Beginning transaction
                DB::beginTransaction();
                try {
                    foreach ($this->genders as $genders) {

                        Gender::create([
                            'gender' => ucwords($genders),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Gender types added successfully!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "There was an issue adding gender category. Please try again");
                }
            }
        }
    }

    // Method to delete category from db (soft method not used)
    public function deleteGenderCategory(int $id):void
    {
        Gate::authorize('delete', Gender::class, $id);
        $gender = Gender::find($id);
        $gender->delete();
    }
    //Method to reset input fields
    public function resetGender():void
    {

        $this->reset('genders');
    }
    public function render()
    {
        $genders = Gender::all();
        return view('livewire.gender-management', ["gendersAll" => $genders]);
    }
}
