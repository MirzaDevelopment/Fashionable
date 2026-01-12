<?php
/*
Livewire backend component used mostly for editing the images in edit product admin panel. It includes:
- Livewire mount method is used to update the class properties (array) with the images already present for chosen product($imagerNames).
So the $imageNames array, will contain elements of already present images in selected product.
- Complete validation rules for images.
- Small helper function "selectImageName()" to retrieve some data for the image user choose, which is then used later for final update.
- Function which triggers on image upload - updatedProductimage(), in which a validation is also applied, so the user can see errors immediately.
- Final Method to change product images wrapped in transaction with implemented Intervention library for image manipulation. It scales down images, and creates a separate image sizes which will eventually b e rendered on different screen sizes.
Image editing components do not have saparate livewire components for rendering the current images in database like other caregories do (HeelEditRender, MaterialEditRender etc...). It's frontend component therefore is immediately rendered in the editproduct.blade.php parent view.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditProductImage extends Component
{
    use WithFileUploads;
    public bool $toggle = false;
    public object $newProduct;
    public bool $isUploading = false; //Toggle property to prevet form submit spam
    public object $activeImages;
    public array $imageNames = [];
    public object $activeColors;
    public array $colorNames = [];
    public array $hexCode = [];
    public array $activeColorsNull = [];
    #[Validate]
    public array $productImage = []; //The one user choses.
    public object $oldImage;
    public string $imageId;
    public object $colorsWithNull;
    public object $combinedColors;



    public function mount(): void
    {

        $this->newProduct = session("newProductModel");
        $this->activeImages = $this->newProduct->images()->get();
        $this->activeColors = $this->newProduct->colors()->get();


        foreach ($this->activeImages as $key => $images) {

            //Rendered in blade template:
            $this->imageNames[] = $images->image_200x200;
            $this->colorNames[] = $this->activeColors[$key]->color;
            $this->hexCode[] = $this->activeColors[$key]->hex_code;
        }
    }


    //Small funciton to retrieve data of selected image - current active image admin clicked on (required for final update)
    public function selectImageName(string $parameter): void
    {

        $this->imageId = DB::table('category_images')
            ->where('image_200x200', $parameter)
            ->pluck('id')
            ->first();

        $this->oldImage = Image::find($this->imageId);
    }
    /*
    Validation
    */

    protected function rules(): array
    {

        $rules = [

            //Product image upload validation for real time
            'productImage.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024|dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200',

        ];

        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [

        //Product image upload validation messages
        'productImage.*.required' => 'Slika proizvoda je obavezna.',
        'productImage.*.image' => 'Pogrešna datoteka! Učitana datoteka mora biti slika.',
        'productImage.*.mimes' => 'Pogrešan tip slike! Slika mora biti u formatu: jpeg, webp, png, jpg, gif ili svg.',
        'productImage.*.max' => 'Pogrešna veličina datoteke! Veličina slike mora biti manja od 1 MB.',
        'productImage.*.dimensions' => 'Pogrešne dimenzije slike! Dimenzije slike moraju biti između 300x300 i 1200x1200.',


    ];


    //To prevent users to edit images if no new images are selected (toggle), also "live" validation is implemented here.
    public function updatedProductimage(): void
    {

        $this->toggle = true;
        $this->validateOnly("productImage.*");
    }

    /*
   Image edit function
    */

    public function editImage(): ?RedirectResponse
    {
        /*
        Preparations
        */
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }
        if ($this->toggle == false) {

            return session()->flash('emptyImages', 'Molimo odaberite nove slike proizvoda prvo');
        }
        Gate::authorize('create', Image::class);
        $this->validate();

        //Beginning transaction
        DB::beginTransaction();
        try {
            $path = [($this->productImage)];
            $manager = new ImageManager(Driver::class);
            $extensions = [".jpg", ".jpeg", ".png", ".svg", ".gif"];
            foreach ($path[0] as $truePath) {
                $RawName = $truePath->getClientOriginalName();
                //Store the original default size image
                $realPath = $truePath->store("images", "public");
                $webPname = str_replace($extensions, ".webp", $RawName);
                //Hash the new resized name
                $hashedWebPName = md5(time() . $webPname) . ".webp";
                //Using intervention package to resize and encode to webP
                $image_200x200 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 200)->encode(new WebpEncoder(quality: 80));
                $image_400x400 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 400)->encode(new WebpEncoder(quality: 80));
                $image_800x800 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 800)->encode(new WebpEncoder(quality: 80));
                $image_1200x1200 = $manager->read(storage_path("app/public/{$realPath}"))->scale(width: 1200)->encode(new WebpEncoder(quality: 80));
                //Saving in appropriate path
                $image_200x200->save(storage_path("app/public/images/200x200/{$hashedWebPName}"));
                $image_400x400->save(storage_path("app/public/images/400x400/{$hashedWebPName}"));
                $image_800x800->save(storage_path("app/public/images/800x800/{$hashedWebPName}"));
                $image_1200x1200->save(storage_path("app/public/images/1200x1200/{$hashedWebPName}"));

                $obsoleteImageOnDisk = Image::find($this->oldImage->id);
                if (Storage::disk('public')->exists($obsoleteImageOnDisk->image_200x200)) {
                    if (!str_contains($obsoleteImageOnDisk->image_path, 'default')) {
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_path);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_200x200);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_400x400);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_800x800);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_1200x1200);
                    } else {
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_200x200);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_400x400);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_800x800);
                        Storage::disk('public')->delete($obsoleteImageOnDisk->image_1200x1200);
                    }
                }

                //Finally saving the path to database
                $this->oldImage->update([
                    'image_path' => $realPath, //Default image size
                    'image_200x200' => 'images/200x200/' . $hashedWebPName,
                    'image_400x400' => 'images/400x400/' . $hashedWebPName,
                    'image_800x800' => 'images/800x800/' . $hashedWebPName,
                    'image_1200x1200' => 'images/1200x1200/' . $hashedWebPName,

                ]);
            }

            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("status", "Slika proizvoda je ažurirana uspješno!");
        } catch (\Exception $e) {

            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom ažuriranja slike proizvoda. Molimo pokušajte kasnije.");
        }
    }



    public function render()
    {

        return view('livewire.edit-product-image');
    }
}
