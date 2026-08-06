<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically size category management. It includes:
- Method to add new input fields for new sizes.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert size category method, with admin authorisation check.
- Method to delete category permanently.
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/

namespace App\Livewire;

use App\Models\Size;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class SizeManagement extends Component
{
    public string $numberPattern = "/^\d+$/";
    public array $sizes = [''];

    // Method to add a new blank input field for another material
    public function addSizeInput(): void
    {
        $this->sizes[] = '';
    }

    //Remove input
    public function removeSizeInput(int $index): void
    {
        unset($this->sizes[$index]);
    }

    //Validation
    protected function rules(): array
    {

        return [
            'sizes' => 'required|array',
            'sizes.*' => [
                'required',
                'min:1',
                'regex:/^\p{L}+(?: \p{L}+)?$|^\d+(?:\.\d+)?(cm|mm|px)?$/iu',
            ],


        ];
    }
    //Custom messages for validation
    protected $messages = [
        'sizes.required' => 'Molimo unesite barem jednu veličinu.',
        'sizes.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'sizes.*.min' => 'Svaka veličina mora sadržavati najmanje jedno slovo.',
        'sizes.*.unique' => 'Otkriven je duplirani unos.',
        'sizes.*.regex' => 'Veličina smije sadržavati slova, brojeve ili mjerne jedinice npr -> 2cm.',
    ];

    //Inserting category in db
    public function insertSize(): RedirectResponse
    {
        Gate::authorize('create', Size::class);

                $this->validate();

                //Beginning transaction
                DB::beginTransaction();
                try {
                    foreach ($this->sizes as $sizes) {
                        //Small distinction in size category
                        if (preg_match($this->numberPattern, $sizes)) {
                            Size::create([
                                'source' => 'user',
                                'size' => ucwords($sizes),
                                'size_type' => "shoe",
                            ]);
                        } else {
                            Size::create([
                                'source' => 'user',
                                'size' => ucwords($sizes),
                                'size_type' => "clothing",
                            ]);
                        }
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Veličine su uspješno dodane.");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja kategorije veličine. Molimo pokušajte kasnije.");
                }
            
        
    }
    // Method to delete category from db (soft method not used)
    public function deleteSizeCategory(int $id): void
    {
        Gate::authorize('delete', Size::class);
        $size = Size::find($id);
        $size->forceDelete();
    }
    //Method to reset input fields
    public function resetSize(): void
    {

        $this->reset('sizes');
    }

    public function render()
    {
        $sizes = Size::all();
        return view('livewire.size-management', ["sizesAll" => $sizes]);
    }
}
