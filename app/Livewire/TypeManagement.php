<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically color category management. It includes:
- Method to add new input fields for new colors.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert color category method, with admin authorisation check.
- Method to delete category permanently.
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
    public function addTypeInput(): void
    {
        $this->types[] = '';
    }
    //Remove input
    public function removeTypeInput(int $index): void
    {
        unset($this->types[$index]);
    }
    //Validation
    protected function rules(): array
    {

        return [
            'types' => 'required|array',
            'types.*' => 'required|min:3|string|unique:types,type_name|regex:/^\p{L}+(?: \p{L}+)?$/u',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'types.required' => 'Molimo unesite barem jednu vrstu odjeće.',
        'types.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'types.*.string' => 'Svaka vrsta odjeće mora biti ispravan tekst.',
        'types.*.min' => 'Svaka vrsta odjeće mora sadržavati najmanje tri slova.',
        'types.*.unique' => 'Otkriven je duplirani unos.',
        'types.*.regex' => 'Vrsta odjeće smije sadržavati samo slova.',
    ];

    //Inserting category in db
    public function insertType(): RedirectResponse
    {
        Gate::authorize('create', Type::class);
                $this->validate();
                //Beginning transaction

                DB::beginTransaction();
                try {
                    foreach ($this->types as $types) {
                        Type::create([
                            'source' => 'user',
                            'type_name' => ucfirst(mb_strtolower($types)),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Vrsta proizvoda je dodana uspješno!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja kategorija vrste proizvoda. Molimo pokušajte kasnije.");
                }
            
    }


    // Method to delete category from db (soft method not used)
    public function deleteTypeCategory(int $id, User $user): void
    {
        Gate::authorize('delete', Type::class);; //Authorisation for admin
        $type = Type::find($id);
        $type->forceDelete();
    }
    //Method to reset input fields
    public function resetType(): void
    {

        $this->reset('types');
    }
    public function render()
    {
        $types = Type::all();
        return view('livewire.type-management', ["typesAll" => $types]);
    }
}
