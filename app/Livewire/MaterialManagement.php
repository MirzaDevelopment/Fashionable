<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically material category management. It includes:
- Method to add new input fields for new materials.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert material category method, with admin authorisation check.
- Method to delete category (soft delete).
- Method to reset input fields.
It's frontend component is also used a child component in categories.blade.php view.
*/

namespace App\Livewire;

use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class MaterialManagement extends Component
{

    public array $materials = [''];

    // Method to add a new blank input field for another material
    public function addMaterialInput(): void
    {
        $this->materials[] = '';
    }

    //Remove input
    public function removeMaterialInput(int $index): void
    {
        unset($this->materials[$index]);
    }

    //Validation
    protected function rules(): array
    {

        return [
            'materials' => 'required|array',
            'materials.*' => 'required|min:3|string|unique:category_materials,material|regex:/^\p{L}+(?: \p{L}+)?$/u',

        ];
    }

    //Custom messages for validation
    protected $messages = [
        'materials.required' => 'Molimo unesite barem jedan tip materijala.',
        'materials.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'materials.*.string' => 'Svaki materijal mora biti ispravan tekst.',
        'materials.*.min' => 'Svaki materijal mora sadržavati najmanje tri slova.',
        'materials.*.unique' => 'Otkriven je duplirani unos.',
        'materials.*.regex' => 'Tip materijala smije sadržavati samo slova.',
    ];

    //Inserting category in db
    public function insertMaterial(): RedirectResponse
    {
        Gate::authorize('create', Material::class);

                $this->validate();

                //Beginning transaction
                DB::beginTransaction();
                try {
                    foreach ($this->materials as $materials) {
                        Material::create([
                            'material' => ucwords($materials),
                        ]);
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Vrste materijala su dodane uspješno.");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja kategorije materijala. Molimo pokušajte kasnije.");
                }
            
        
    }


    // Method to delete category from db (soft method not used)
    public function deleteMaterialCategory(int $id): void
    {
        Gate::authorize('delete', Material::class);
        $material = Material::find($id);
        $material->forceDelete();
    }
    //Method to reset input fields
    public function resetMaterial(): void
    {

        $this->reset('materials');
    }
    public function render()
    {
        $materials = Material::all();
        return view('livewire.material-management', ["materialsAll" => $materials]);
    }
}
