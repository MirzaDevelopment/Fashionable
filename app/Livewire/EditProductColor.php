<?php
/*
This is a backend livewire component mostly used to edit product color categories. It inluces methods:
- Livewire mount method - which updates class properties with the one active in the database. This is mostly used to show the admin current product colors. However it also contains a query to obtain current selected product sizes (it is later use for proper products_variants pivot table update)
- Validation rules with corresponding messages.
- Select and deselect methods to update the class properties with the value user selected or deselected from available color categories.
- Method to edit color categories in product (remove current ones, or add new ones).
- Method to reset input(edit) fields.
- Main product edit methods, that allows user to select new or deselect current categories, and upload the state as a current color for chosen product. Wrapped in transaction.
- For every new color that is added, default image will be provided. (Which admin can change later on).
- For every new color that is added, default value for stock is added for each active size (default is 0)
- When user removes a color, image path for that image in database will also be removed (to prevent cluttering)
- Method to reset input fields.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use App\Models\Color;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditProductColor extends Component
{


    public bool $isUploading = false;
    public array $activeColors = [];
    public array $activeSizesId = [];
    public object $variantStocks;
    #[Validate]
    public object $newProduct;
    public array $colorSelect = [];
    public array $colorDeSelect = [];
    public bool $toggle;
    public int $defaultImageId; //An id of the default image which will be used for new colors until admin changes to correct one.
    public string $imagePath;



    public function mount(): void
    {
        //Mostly important to show the admin current product data
       $this->newProduct = session("newProductModel");
        
        //For adding default stock value to new color
        $this->variantStocks = DB::table("products_variants")->where('product_id', $this->newProduct->id)->get();
        foreach ($this->variantStocks as $sizes) {

            $this->activeSizesId[] = $sizes->category_size_id;
        }

        $defaultImage = Image::where("image_320x320", 'like', "%default%")->orderBy("created_at", "desc")->first();
        if (!empty($defaultImage)) {
            $this->defaultImageId = $defaultImage->id;
        } else {
            return;
        }
        $this->imagePath = $defaultImage->image_path;
    }


    /*
   Colors select and edit
    */

    //Visual change of selected colors
    public function ColorSelect(string $parameter): void
    {

        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->colorSelect)) {
            $index = array_search($parameter, $this->colorSelect);
            unset($this->colorSelect[$index]);
        } else {


            $this->colorSelect[] = $parameter;
        }
    }



    //Visual change of deselected colors
    public function ColorDeSelect(string $parameter): void
    {
        $this->toggle = false;
        $this->isUploading = false;
        if (in_array($parameter, $this->colorDeSelect)) {
            $index = array_search($parameter, $this->colorDeSelect);
            unset($this->colorDeSelect[$index]);
        } else {


            $this->colorDeSelect[] = $parameter;
        }
    }

    //Edit product colors
    public function editColors(): ?RedirectResponse
    {
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }
        //Getting unique (non duplicate) array of sizes id (used later for pivot table update)
        $uniqueArraySizesId = array_values(array_unique($this->activeSizesId));
        $this->activeColors = $this->newProduct->colors()->get()->toArray();
        foreach ($this->activeColors as $colorName) {


            $currentColorArray[] = $colorName["color"];
        }

        //to prevent updating without selecting at least one color category
        sort($this->colorDeSelect);
        sort($currentColorArray);
        if ($this->colorDeSelect == $currentColorArray && empty($this->colorSelect)) {


            return session()->flash('emptyColors', 'Molimo odaberite barem jednu boju iz kategorije.');
        }
        Gate::authorize('create', Color::class);
        //Beginning transaction
        DB::beginTransaction();
        try {
            //Scenario one - admin choses extra categories while keeping original ones
            if (count(array_diff($this->colorSelect, $currentColorArray)) > 0) {
                $colors = [($this->colorSelect)];
                $resultsColors = Color::whereIn('color', $colors[0])->get();
                //Sorting colors...
                $sortedResultsColors = $resultsColors->sortBy(function ($colorArray) use ($colors) {
                    return array_search($colorArray->color, $colors[0]);  // Sort based on input array order
                });
                //...getting color id
                $idsColors = $sortedResultsColors->pluck('id')->toArray();

                //Putting the default image for the chosen colors
                foreach ($idsColors as $key => $idsColors) {

                    //Image is copied to the same path but with different name
                    $defaultImageName = "default" . $key . ".webp";

                    $originalImagePath = storage_path('app/public/images/320x320/default.webp');


                    $newImagePath = storage_path('app/public/images/320x320/' . $defaultImageName);



                    File::copy($originalImagePath, $newImagePath);

                    //Finally corresponding entries are created in database
                    $imageIdArray[] = Image::create([
                        'image_path' =>  $this->imagePath, //Default image size
                        'image_320x320' => 'images/320x320/' . $defaultImageName,
                        'image_400x400' => 'images/400x400/' . $defaultImageName,
                        'image_800x800' => 'images/800x800/' . $defaultImageName,
                        'image_1200x1200' => 'images/1200x1200/' . $defaultImageName,

                    ]);

                    //Ataching in pivot products_colors
                    $idsForColors[] = $imageIdArray[$key]->id;
                    $this->newProduct->colors()->attach($idsColors, ["category_image_id" => $idsForColors[$key]]);

                    //Attaching in pivot products_variants (for new chosen color)
                    foreach ($uniqueArraySizesId  as  $idsSizes) {

                        $this->newProduct->colorsVariant()->attach($idsColors, ['category_size_id' =>  $idsSizes]);
                    }
                }


                //Small check to make sure user actually changes something in color panel
            } else if ((count(array_intersect($this->colorDeSelect, $currentColorArray)) == 0)) {

                return session()->flash('errorColors', 'Ova boja je već prisutna za ovaj proizvod');
            }
            if ($this->colorDeSelect) {
                //Scenario two - admin deletes original categories (soft deletes)
                $colors = [($this->colorDeSelect)];
                $resultsColors = Color::whereIn('color', $colors[0])->get();
                //Sorting colors...
                $sortedResultsColors = $resultsColors->sortBy(function ($colorArray) use ($colors) {
                    return array_search($colorArray->color, $colors[0]);  // Sort based on input array order
                });
                //...getting color id
                $idsColors = $sortedResultsColors->pluck('id')->toArray();

                //Removing the leftover entries from category_images tables in database when color is removed
                $colors = Color::whereIn('id', $idsColors)->get()->toArray();

                foreach ($colors as $colorId) {
                    $imageId[] = DB::table('products_colors')
                        ->where('category_color_id', $colorId)
                        ->value('category_image_id');
                }
                $obsoleteImageOnDisk = Image::find($imageId);
                foreach ($obsoleteImageOnDisk as $obsoleteImageOnDisk) {
                    if (Storage::disk('public')->exists($obsoleteImageOnDisk->image_320x320)) {
                        if (!str_contains($obsoleteImageOnDisk->image_path, 'default')) {
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_path);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_320x320);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_400x400);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_800x800);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_1200x1200);
                        } else {
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_320x320);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_400x400);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_800x800);
                            Storage::disk('public')->delete($obsoleteImageOnDisk->image_1200x1200);
                        }
                    }
                }
                //Deleting the obsolete image entry from database (no soft delete to prevent cluttering)
                Image::destroy($imageId);


                //...finally removing the color from pivot table (product_colors)
                $this->newProduct->colors()->detach($idsColors);

                //...also remmoving stocks in pivot products_variants
                $uniqueArraySizesId = array_values(array_unique($this->activeSizesId));
                foreach ($uniqueArraySizesId  as  $idsSizes) {

                    $this->newProduct->colorsVariant()->detach($idsColors, ['category_size_id' =>  $idsSizes]);
                }
            }
            DB::commit();
            $this->isUploading = true;

            return redirect()->back()->with("status", "Ažurirali ste kategoriju boja uspješno. Molimo da osvježite stranicu i da odaberete odgovarajuću sliku za vašu novu boju.");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem pri ažuriranju boja proizvoda.");
        }
    }







    public function render()
    {
        return view('livewire.edit-product-color');
    }
}
