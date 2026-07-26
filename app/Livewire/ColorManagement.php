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

use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ColorManagement extends Component
{

    public array $colors = [''];
    public array $colorPicked = ["#000000"]; //Default input color
    public array $colorUserPicked = []; //Colors that user picked

    // Method to add a new blank input field for another material
    public function addColorInput(): void
    {
        $this->colors[] = '';
        $this->colorPicked[] = "#000000";
    }
    //Update variable when user picks color
    public function updatedcolorPicked(): array
    {

        $colorUserPicked = $this->colorPicked;
        return $colorUserPicked;
    }

    //Remove input
    public function removeColorInput(int $index)
    {
        unset($this->colors[$index]);
        unset($this->colorPicked[$index]);
    }
    //Validation
    protected function rules(): array
    {

        return [
            'colors' => 'required|array',
            'colors.*' => 'required|min:3|string|unique:category_colors,color|regex:/^\p{L}+(?: \p{L}+)?$/u',
            'colorPicked' => 'required|array',
            'colorPicked.*' => 'unique:category_colors,hex_code'
        ];
    }

    //Custom messages for validation
    protected $messages = [
        'colors.required' => 'Molimo unesite barem jednu boju.',
        'colors.*.required' => 'Svako dodano polje mora biti popunjeno.',
        'colors.*.string' => 'Svaka boja mora biti ispravan tekst.',
        'colors.*.min' => 'Svaka boja mora sadržavati najmanje tri slova.',
        'colors.*.unique' => 'Otkrivena je duplirana boja.',
        'colors.*.regex' => 'Boja smije sadržavati samo slova.',
        'colorPicked.*.unique' => 'Otkrivena je duplirana boja.',
    ];

    //Inserting category in db
    public function insertColor(): RedirectResponse
    {
        Gate::authorize('create', Color::class);
        //Checking if color is already present but soft deleted (to prevent unique validation error)
        //Preparations first
        $this->colorUserPicked = $this->updatedcolorPicked(); //Getting chosen color
        $hex_codes_present = Color::pluck('hex_code', 'id')->toArray(); //Getting hex_codes already stored
        foreach ($this->colors as $key => $colors) {
            if ($colorsDeleted = Color::onlyTrashed()->where('color', $colors)->first()) {
                if (in_array($this->colorUserPicked[$key], $hex_codes_present)) {
                    return redirect()->back()->with("errorException", "Nastao je problem tokom dodavanja kategorije boje: Otkrivena je duplirana boja");
                } else {

                    $colorsDeleted->restore();
                    return redirect()->back()->with("status", "Tipovi boje su uspješno dodani!");
                    Color::where('color', $colors)->update(['hex_code' => $this->colorUserPicked[$key]]);
                }
            } else {
                //...if not, continue with regular insert
                $this->validate();

                //Beginning transaction
                DB::beginTransaction();
                try {
                    foreach ($this->colors as $key => $colors) {
                        Color::create([
                            'color' => str_replace(' ', '', ucfirst(strtolower($colors))),
                            'hex_code' => $this->colorUserPicked[$key],
                        ]);
                    }

                    DB::commit();
                    return redirect()->back()->with("status", "Tipovi boje su uspješno dodani!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja kategorije boje. Molimo pokušajte ponovo.");
                }
            }
        }
    }
    // Method to delete category from db
    public function deleteColorCategory(int $id): void
    {
        Gate::authorize('delete', Color::class);
        $color = Color::find($id);
        $color->delete();
    }

    //Method to reset input fields
    public function resetColor(): void
    {

        $this->reset(['colors', 'colorPicked', 'colorUserPicked']);
    }

    public function render()
    {
        $colors = Color::all();
        return view('livewire.color-management', ["colorsAll" => $colors]);
    }
}
