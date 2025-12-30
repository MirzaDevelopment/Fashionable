<?php
/*
This is a backend class in livewire framework used for category management (add and delete), specifically size category management. It includes:
- Method to add new input fields for new sizes.
- Method to remove unecessary input fields.
- Method to update the variable to the one admin chose wrapped in transaction.
- Validation rules with corresponding messages.
- Insert size category method, with admin authorisation check.
- Method to delete category (soft delete).
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
    public function addSizeInput():void
    {
        $this->sizes[] = '';
    }

    //Remove input
    public function removeSizeInput(int $index):void
    {
        unset($this->sizes[$index]);
    }

    //Validation
    protected function rules():array
    {

        return [
            'sizes' => 'required|array',
            'sizes.*' => [
                'required',
                'min:1',
                'regex:/^[A-Za-z]+( [A-Za-z]+)?$|^\d+$/',
            ],


        ];
    }
    //Custom messages for validation
    protected $messages = [
        'sizes.required' => 'Please provide at least one size.',
        'sizes.*.required' => 'Each added input must be filled.',
        'sizes.*.min' => 'Each size must contain at least one letter.',
        'sizes.*.unique' => 'Duplicate entry detected.',
        'sizes.*.regex' => 'Size must contain only letters or numbers.',
    ];

    //Inserting category in db
    public function insertSize():RedirectResponse
    {
         Gate::authorize('create', Size::class);
        //Checking if size is already present but soft deleted (to prevent unique validation error)
        foreach ($this->sizes as $sizes) {

            if ($sizesDeleted = Size::onlyTrashed()->where('size', $sizes)->first()) {
                $sizesDeleted->restore();
                return redirect()->back()->with("status", "Size types added successfully!");
            } else {
                //...if not, continue with regular insert
                $this->validate();
               
                //Beginning transaction
                DB::beginTransaction();
                try {
                    foreach ($this->sizes as $sizes) {
                        //Small distinction in size category
                        if (preg_match($this->numberPattern, $sizes)) {
                            Size::create([
                                'size' => ucwords($sizes),
                                'size_type' => "shoe",
                            ]);
                        } else {
                            Size::create([
                                'size' => ucwords($sizes),
                                'size_type' => "clothing",
                            ]);
                        }
                    }
                    DB::commit();
                    return redirect()->back()->with("status", "Size types added successfully!");
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback the transaction on error
                    Log::error('Error occurred: ' . $e->getMessage());
                    return redirect()->back()->with("errorException", "There was an issue adding size category. Please try again");
                }
            }
        }
    }
    // Method to delete category from db (soft method not used)
    public function deleteSizeCategory(int $id):void
    {
        Gate::authorize('delete', Size::class);
        $size = Size::find($id);
        $size->delete();
    }
    //Method to reset input fields
    public function resetSize():void
    {

        $this->reset('sizes');
    }

    public function render()
    {
        $sizes = Size::all();
        return view('livewire.size-management', ["sizesAll" => $sizes]);
    }
}
