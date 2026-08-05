<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically heel category management. It includes:
- Method to add new input fields for new heels.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert heel category method, with admin authorisation check.
- Method to delete category (soft delete).
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/

namespace App\Livewire;

use App\Models\Heel;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class HeelManagement extends Component
{


    public array $heels = [''];

    // Method to add a new blank input field for another material
    public function addHeelInput(): void
    {
        $this->heels[] = '';
    }

    //Remove input
    public function removeHeelInput(int $index): void
    {
        unset($this->heels[$index]);
    }

    //Validation
    protected function rules(): array
    {

        return [
            'heels' => 'required|array',
            'heels.*' => 'required|min:3|string|unique:heels,heel_type|regex:/^\p{L}+(?: \p{L}+)?$/u',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'heels.required' => 'Molimo unesite barem jedan tip štikle.',
        'heels.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'heels.*.string' => 'Svaki tip štikle mora biti ispravan tekst.',
        'heels.*.min' => 'Svaki tip štikle mora sadržavati najmanje tri slova.',
        'heels.*.unique' => 'Otkriven je duplirani unos.',
        'heels.*.regex' => 'Tip štikle smije sadržavati samo slova.',

    ];

    //Inserting category in db
    public function insertHeel(): RedirectResponse
    {
        Gate::authorize('create', Heel::class);

                $this->validate();

                //Beginning transaction

                DB::beginTransaction();
                try {
                    foreach ($this->heels as $heels) {
                        Heel::create([
                            'source' => 'user',
                            'heel_type' => ucwords($heels),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Vrste štikli su dodane uspješno.");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja kategorije štikli. Molimo pokušajte ponovo.");
                }
            
        
    }

    // Method to delete category from db (soft method not used)
    public function deleteHeelCategory(int $id): void
    {
        Gate::authorize('delete', Heel::class);
        $heel = Heel::find($id);
        $heel->forceDelete();
    }
    //Method to reset input fields
    public function resetHeel(): void
    {

        $this->reset('heels');
    }
    public function render()
    {
        $heels = Heel::all();
        return view('livewire.heel-management', ["heelsAll" => $heels]);
    }
}
