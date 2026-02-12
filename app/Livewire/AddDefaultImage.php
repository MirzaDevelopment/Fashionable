<?php
/*
This is a backend class in livewire framework that does all the backend logic in the upload default image functionality. 
Default image, is just a placeholder image a user(admin) can upload to represent new colors that don't have an associated image yet.
It is usable during the modification of the existing products - adding new colors that don't have the associated image yet, where this uploaded image will be shown.
This component icludes includes:
- All the validation rules with corresponding messages.
- Default image method with admin authorisation wrapped in transaction.
Notice - "isUploading" property is used to prevent a submit spam.
*/
namespace App\Livewire;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
class AddDefaultImage extends Component
{
    use WithFileUploads;
    #[Validate]
    public ?object $defaultImage=null;
    public bool $isUploading = false; //Toggle property to prevet form submit spam
    public bool $lightBox = false;

    /*
    Validation
    */
    protected function rules():array
    {

        $rules = [

            'defaultImage'=> 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024|dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200'
        ];


        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [
        //Default image upload validation messages
        'defaultImage.required' => 'Odaberite zamjensku sliku za proizvod.',
        'defaultImage.image' => 'Odabrana pogrešna datoteka! Datoteka mora biti slika.',
        'defaultImage.mimes' => 'Odabrana pogrešna vrsta datoteke! Datoteka mora biti slika u formatu: jpeg, webp, png, jpg, gif, svg.',
        'defaultImage.max' => 'Pogrešna veličina slike! Veličina slike mora biti manja od 1 megabajta.',
        'defaultImage.dimensions' => 'Pogrešne dimenzije slike! Dimenzije slike moraju biti između 300x300 and 1200x1200.',

    ];





//Small function for uploading an image which will be rendered when no appropriate image is found

public function defaultImageUpload():?RedirectResponse
{
    Gate::authorize('create', Image::class);
    if ($this->isUploading) {
        return null; // Prevent further submissions if already uploading
    }

    $this->validate();
    //Beginning transaction
    DB::beginTransaction();
    try {
        $path = ($this->defaultImage);
        $manager = new ImageManager(Driver::class);
        $extensions = [".jpg", ".jpeg", ".png", ".svg", ".gif"];
        $RawName = $path->getClientOriginalName();
        $defaultImageName = "default" . ".webp";
        //Store the original default size image
        //$realPath = $path->store("images", "public");
        $realPath = $path->storeAs('images', $defaultImageName, 'public');
        $webPname = str_replace($extensions, ".webp", $RawName);
        //Hash the new resized name
        //Using intervention package to resize and encode to webP
        $image_200x200 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 200)->encode(new WebpEncoder(quality: 80));
        $image_400x400 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 400)->encode(new WebpEncoder(quality: 80));
        $image_800x800 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 800)->encode(new WebpEncoder(quality: 80));
        $image_1200x1200 = $manager->read(storage_path("app/public/{$realPath}"))->scale(width: 1200)->encode(new WebpEncoder(quality: 80));
        //Saving in appropriate path
        $image_200x200->save(storage_path("app/public/images/200x200/{$defaultImageName}"));
        $image_400x400->save(storage_path("app/public/images/400x400/{$defaultImageName}"));
        $image_800x800->save(storage_path("app/public/images/800x800/{$defaultImageName}"));
        $image_1200x1200->save(storage_path("app/public/images/1200x1200/{$defaultImageName}"));
        //Finally saving the path to database
        $imageIdArray[] = Image::create([
            'image_path' => $realPath, //Default image size
            'image_200x200' => 'images/200x200/' . $defaultImageName,
            'image_400x400' => 'images/400x400/' . $defaultImageName,
            'image_800x800' => 'images/800x800/' . $defaultImageName,
            'image_1200x1200' => 'images/1200x1200/' . $defaultImageName,

        ]);
        DB::commit();
        $this->isUploading = true;
        return redirect()->back()->with("statusDefault", "Zamjenska slika je uspješno učitana! Ova slika će se koristiti kada ne bude pronađena slika za odgovarajuću boju.");
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction on error
        $this->isUploading = false;
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with("errorException", "Nastao je problem tokom učitavanja zamjenske slike. Molimo pokušajte ponovo.");
    }
}


    public function render()
    {
        return view('livewire.add-default-image');
    }
}
