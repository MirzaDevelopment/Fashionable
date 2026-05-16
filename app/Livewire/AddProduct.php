<?php
/*
This is a backend class in livewire framework that does all the backend logic in the upload product functionality. 
It includes:
- Select logic for categories that also visualy changes the selected category in frontend for the admin.
- All the validation rules with corresponding messages.
- Product upload method in 4 parts with admin authorisation wrapped in transaction.
- Product is also uploaded with default quantity ("0") for each color/size variation.
- Method to reset input fields.
- Method to toggle product preview light box.
- Helper method to correctly display applied discount for Admin.
- Helper Method to reset discount precentage to "empty" if price is changed in the mean time.
Notice - "isUploading" property is used to prevent a submit spam.
*/

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Type;
use App\Models\Heel;
use App\Models\Gender;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Image;
use App\Models\Material;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;


class AddProduct extends Component
{

    use WithFileUploads;
    const DELIVERY = 9.50; //Shipping cost
    public bool $isUploading = false; //Toggle property to prevet form submit spam
    public bool $lightBox = false;
    #[Validate]
    public string $productName;
    #[Validate]
    public string $productDescription;
    #[Validate]
    public ?float $productPrice = null;
    #[Validate]
    public ?float $productDiscount = null;
    #[Validate]
    public ?string $startDate = null;
    #[Validate]
    public ?string $endDate = null;
    #[Validate]
    public int $productId; //Used also for routing parameter towards stock management
    public array $colorSelect = [];
    public array $genderSelect = [];
    public array $tagSelect = [];
    public array $heelSelect = [];
    public array $materialSelect = [];
    public array $sizeSelect = [];
    public array $typeSelect = [];
    public array $productImage = [];
    public array $colorRender = [];
    public int $productDiscountedPrice;
    public string $validationFailedExtraMessage;


    /*
    Categories select
    */

    //Visual change of selected colors
    public function ColorSelect(string $parameter): void
    {
        if (in_array($parameter, $this->colorSelect)) {
            $index = array_search($parameter, $this->colorSelect);
            unset($this->colorSelect[$index]);
            unset($this->colorRender[$index]);
        } else {
            $this->colorSelect[] = $parameter;
            $hexCodeModel = Color::whereIn('color', $this->colorSelect)->get();
            //Sorting colors...
            $sortedResults =  $hexCodeModel->sortBy(function ($colorArray) {
                return array_search($colorArray->color, $this->colorSelect);  // Sort based on input array order
            });
            //Used for "Available in" part.
            $hexModelVariable = $sortedResults->pluck('hex_code')->toArray();
            $this->colorRender = $hexModelVariable;
        }
    }

    //Visual change of selected genders
    public function GenderSelect(string $parameter): void
    {

        if (in_array($parameter, $this->genderSelect)) {
            $index = array_search($parameter, $this->genderSelect);
            unset($this->genderSelect[$index]);
        } else {
            $this->genderSelect[] = $parameter;
        }
    }

    //Visual change of selected tags
    public function TagSelect(string $parameter): void
    {

        if (in_array($parameter, $this->tagSelect)) {
            $index = array_search($parameter, $this->tagSelect);
            unset($this->tagSelect[$index]);
        } else {
            $this->tagSelect[] = $parameter;
        }
    }

    //Visual change of selected Heels
    public function HeelSelect(string $parameter): void
    {

        if (in_array($parameter, $this->heelSelect)) {
            $index = array_search($parameter, $this->heelSelect);
            unset($this->heelSelect[$index]);
        } else {
            $this->heelSelect[] = $parameter;
        }
        //Allowing user to select only one heel type
        if (count($this->heelSelect) > 1) {
            $index = array_search($parameter, $this->heelSelect);
            unset($this->heelSelect[$index]);
            session()->flash('errorHeel', 'Molimo odaberite samo jedan tip štikle!');
        };
    }


    //Visual change of selected materials
    public function MaterialSelect(string $parameter): void
    {

        if (in_array($parameter, $this->materialSelect)) {
            $index = array_search($parameter, $this->materialSelect);
            unset($this->materialSelect[$index]);
        } else {


            $this->materialSelect[] = $parameter;
        }
    }

    //Visual change of selected sizes
    public function SizeSelect(string $parameter): void
    {

        if (in_array($parameter, $this->sizeSelect)) {
            $index = array_search($parameter, $this->sizeSelect);
            unset($this->sizeSelect[$index]);
        } else {
            $this->sizeSelect[] = $parameter;
        }
    }

    //Visual change of selected product types
    public function TypeSelect(string $parameter): void
    {

        if (in_array($parameter, $this->typeSelect)) {
            $index = array_search($parameter, $this->typeSelect);
            unset($this->typeSelect[$index]);
        } else {
            $this->typeSelect[] = $parameter;
        }
        //Allowing user to select only one product type
        if (count($this->typeSelect) > 1) {
            $index = array_search($parameter, $this->typeSelect);
            unset($this->typeSelect[$index]);
            session()->flash('errorType', 'Molimo odaberite samo jedan tip proizvoda!');
        };
    }

    /*
    Price and discount manipulation
    */
    public function updatedproductDiscount(): void
    {
        //Logic to display discounted price for the admin.
        if ($this->productDiscount) {

            $this->productDiscountedPrice = ($this->productPrice) - ($this->productPrice * $this->productDiscount / 100);
        } else if (empty($this->productDiscount)) {
            $this->productDiscount = null;
        }
    }
    //Resetting discount precentage to empty if price is changed 
    public function updatedproductPrice(): void
    {
        unset($this->productDiscount);
    }

    /*
    Validation
    */
    protected function rules(): array
    {

        $rules = [
            //Product name validation
            'productName' => "required|min:3|string|regex:/^[\p{L}\s']+( [\p{L}\s']+)?$/u",
            //Product description validation
            'productDescription' => 'required|string|min:10|max:1000',
            //Product price validation
            'productPrice' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            //Product discount validation
            'productDiscount' => 'nullable|numeric|between:0,100|regex:/^\d+(\.\d{1,2})?$/',
            //Discount start and end date validation
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            //Category colors validation
            'colorSelect' => 'required',
            'genderSelect' => 'required',
            'typeSelect' => 'required',
            'materialSelect' => 'required',
            'sizeSelect' => 'required',
            'heelSelect' => 'nullable',
            'tagSelect' => 'nullable',
            //Product image upload validation for real time
            'productImage.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024|dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200',
        ];
        //Product image upload validation
        foreach ($this->colorSelect as $index => $image) {
            $rules['productImage.' . $index] = 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024|dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200';
        }

        return $rules;
    }

    /*
    Custom messages for validation
    */
    protected $messages = [
        //Product name validation messages
        'productName.required' => 'Molimo unesite naziv proizvoda.',
        'productName.string' => 'Naziv proizvoda smije sadržavati samo slova.',
        'productName.min' => 'Naziv proizvoda mora sadržavati najmanje tri slova.',
        'productName.regex' => 'Naziv proizvoda smije sadržavati samo slova.',
        // Product description validation messages
        'productDescription.required' => 'Molimo unesite opis proizvoda.',
        'productDescription.string' => 'Opis proizvoda mora biti ispravan tekst.',
        'productDescription.min' => 'Opis proizvoda mora imati najmanje 10 karaktera.',
        'productDescription.max' => 'Opis proizvoda ne smije prelaziti 1000 karaktera.',
        // Product Price validation messages
        'productPrice.required' => 'Početna cijena proizvoda je obavezna.',
        'productPrice.numeric' => 'Cijena proizvoda mora biti broj.',
        'productPrice.regex' => 'Cijena mora biti ispravan broj sa dvije decimale (npr. 25.45, 100.00).',
        'product_price.gt' => 'Cijena mora biti veća od 0.',
        // Product discount validation messages
        'productDiscount.numeric' => 'Popust mora biti ispravan broj.',
        'productDiscount.between' => 'Procenat popusta mora biti između 0 i 100.',
        'productDiscount.regex' => 'Popust mora biti ispravan broj sa najviše dvije decimale.',
        // Discount start and end date validation messages
        'startDate' => 'Uneseni datum početka popusta nije ispravan.',
        'endDate' => 'Uneseni datum završetka popusta nije ispravan.',
        // Category select validation messages
        'colorSelect.required' => 'Molimo odaberite boju za vaš proizvod.',
        'genderSelect.required' => 'Molimo odaberite odgovarajući spol za vaš proizvod.',
        'typeSelect.required' => 'Molimo odaberite tip proizvoda.',
        'materialSelect.required' => 'Molimo odaberite materijal proizvoda.',
        'sizeSelect.required' => 'Molimo odaberite veličinu proizvoda.',
        // Product image upload validation messages
        'productImage.*.required' => 'Slika proizvoda je obavezna.',
        'productImage.*.image' => 'Pogrešna datoteka! Učitana datoteka mora biti slika.',
        'productImage.*.mimes' => 'Pogrešan tip slike! Slika mora biti u formatu: jpeg, webp, png, jpg, gif ili svg.',
        'productImage.*.max' => 'Pogrešna veličina datoteke! Veličina slike mora biti manja od 1 MB.',
        'productImage.*.dimensions' => 'Pogrešne dimenzije slike! Dimenzije slike moraju biti između 300x300 i 1200x1200.',

    ];

    //Real life validation of image
    public function updatedproductImage(): void
    {
        $this->validateOnly("productImage.*");
    }


    /*
    Product insert
    */
    public function uploadProduct(): ?RedirectResponse
    {
        Gate::authorize('create', Product::class);
        /*
        General preparations
        */
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }

        
        if(empty($this->productName) | empty($this->productDescription) | empty($this->productPrice) | empty($this->colorSelect) | empty($this->genderSelect) | empty($this->materialSelect) | empty ($this->sizeSelect) | empty($this->typeSelect)|empty($this->productImage)){
          $this->validationFailedExtraMessage="Greška! Molimo provjerite da li ste popunili sve obavezne kategorije!";
        }

        $this->validate();
 
        //Making sure both discount and dates are selected
        if (!(empty($this->productDiscount)) && empty($this->startDate) && empty($this->endDate)) {

            return session()->flash('errorDates', 'Molimo odaberite početni i završni datum trajanja popusta!');
        }

        //Beginning transaction
        DB::beginTransaction();
        try {
            /*
        Part I - Inserting product general info in "main" table
        */
            /*
        Preparations
        */
            //Getting heel id from the selected heel name
            //Small "if else" necessary because heel type can be null.
            if (empty($this->heelSelect)) {
                $idsHeels[0] = null;
            } else {
                $heels = [($this->heelSelect)];
                $resultsHeels = Heel::whereIn('heel_type', $heels[0])->get();
                //Sorting heels...
                $sortedResultsHeels = $resultsHeels->sortBy(function ($heelArray) use ($heels) {
                    return array_search($heelArray->heel_type, $heels[0]);  // Sort based on input array order
                });
                //...getting heel id for general product data
                $idsHeels = $sortedResultsHeels->pluck('id')->toArray();
            }
            //Getting tag id from the selected tag name
            //Small "if else" necessary because tag type can be null.
            if (empty($this->tagSelect)) {
                $idsTags[0] = null;
            } else {
                $tags = [($this->tagSelect)];
                $resultsTags = Tag::whereIn('tag', $tags[0])->get();
                //Sorting heels...
                $sortedResultsTags = $resultsTags->sortBy(function ($tagArray) use ($tags) {
                    return array_search($tagArray->tag, $tags[0]);  // Sort based on input array order
                });
                //...getting heel id for general product data
                $idsTags = $sortedResultsTags->pluck('id')->toArray();
            }

            //Getting type id from the selected type name
            $types = [($this->typeSelect)];
            $resultsTypes = Type::whereIn('type_name', $types[0])->get();
            //Sorting types...
            $sortedResultsTypes = $resultsTypes->sortBy(function ($typeArray) use ($types) {
                return array_search($typeArray->type_name, $types[0]);  // Sort based on input array order
            });
            //...getting type id for general product data
            $idsTypes = $sortedResultsTypes->pluck('id')->toArray();

            //Inserting into product main table (general data);
            $product = Product::create([
                'product_name' => ucfirst($this->productName),
                'description' => $this->productDescription,
                'heel_id' => $idsHeels[0],
                'type_id' => $idsTypes[0],

            ]);
            /* 
        Part II - inserting category data in corresponding pivot tables
        */
            //Getting the correct product object
            $this->productId = $product->id;
            $product = Product::find($this->productId);

            //We got these earlier on. So lets keep pivot table clean if no tags are selected
            if (!empty($this->tagSelect)) {
                $product->tags()->attach($idsTags);
            }

            //Getting gender id from the selected gender name
            $genders = [($this->genderSelect)];
            $resultsGenders = Gender::whereIn('gender', $genders[0])->get();
            //Sorting genders...
            $sortedResultsGenders = $resultsGenders->sortBy(function ($genderArray) use ($genders) {
                return array_search($genderArray->gender, $genders[0]);  // Sort based on input array order
            });
            //...getting gender id
            $idsGenders = $sortedResultsGenders->pluck('id')->toArray();
            //Inserting data into products_genders pivot table
            $product->genders()->attach($idsGenders);

            //Getting size id from the selected sizes name
            $sizes = [($this->sizeSelect)];
            $resultsSizes = Size::whereIn('size', $sizes[0])->get();
            //Sorting sizes...
            $sortedResultsSizes = $resultsSizes->sortBy(function ($sizeArray) use ($sizes) {
                return array_search($sizeArray->size, $sizes[0]);  // Sort based on input array order
            });
            //...getting size id
            $idsSizes = $sortedResultsSizes->pluck('id')->toArray();



            //Getting material id from the selected material name
            $materials = [($this->materialSelect)];
            $resultsMaterials = Material::whereIn('material', $materials[0])->get();
            //Sorting materials...
            $sortedResultsMaterials = $resultsMaterials->sortBy(function ($materialArray) use ($materials) {
                return array_search($materialArray->material, $materials[0]);  // Sort based on input array order
            });
            //...getting material id
            $idsMaterials = $sortedResultsMaterials->pluck('id')->toArray();
            $product->materials()->attach($idsMaterials);

            //Product image and colors pivot table insert
            $path = [($this->productImage)];
            //ImageManager class instance
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
                $image_320x320 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 320)->encode(new WebpEncoder(quality: 80));
                $image_400x400 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 400)->encode(new WebpEncoder(quality: 80));
                $image_800x800 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 800)->encode(new WebpEncoder(quality: 80));
                $image_1200x1200 = $manager->read(storage_path("app/public/{$realPath}"))->scale(width: 1200)->encode(new WebpEncoder(quality: 80));
                //Saving in appropriate path
                $image_320x320->save(storage_path("app/public/images/320x320/{$hashedWebPName}"));
                $image_400x400->save(storage_path("app/public/images/400x400/{$hashedWebPName}"));
                $image_800x800->save(storage_path("app/public/images/800x800/{$hashedWebPName}"));
                $image_1200x1200->save(storage_path("app/public/images/1200x1200/{$hashedWebPName}"));
                //Finally saving the path to database
                $imageIdArray[] = Image::create([
                    'image_path' => $realPath, //Default image size
                    'image_320x320' => 'images/320x320/' . $hashedWebPName,
                    'image_400x400' => 'images/400x400/' . $hashedWebPName,
                    'image_800x800' => 'images/800x800/' . $hashedWebPName,
                    'image_1200x1200' => 'images/1200x1200/' . $hashedWebPName,

                ]);
            }
            //Getting the needed id for pivot table
            foreach ($imageIdArray as $imageId) {
                $finalIds[] = $imageId->id;
            }

            $colors = [($this->colorSelect)];

            $results = Color::whereIn('color', $colors[0])->get();

            //Some sorting to get correct results.
            $sortedResults = $results->sortBy(function ($colorArray) use ($colors) {
                return array_search($colorArray->color, $colors[0]);  // Sort based on input array order
            });


            //...getting color id
            $ids = $sortedResults->pluck('id')->toArray();

            //Loop for adding ids in products_color pivot table
            foreach ($ids as $key => $itemIds) {
                $product->colors()->attach($itemIds, ['category_image_id' => $finalIds[$key]]);
            }

            //Final loop for adding ids in the product_variants pivot table
            foreach ($idsSizes as  $idsSizes) {

                $product->colorsVariant()->attach($ids, ['category_size_id' =>  $idsSizes]);
            }


            /*
        Part III - inserting price data, and displaying correct price regarding the used discount.
        */

            Price::create([
                'product_id' => $this->productId,
                'price' => $this->productPrice,
                'discount' => $this->productDiscount,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);
          
            session(['newProductModel' =>$product]);

            /*
        Part IV - return message
        */
            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("status", "Uspješno ste dodali vaš proizvod!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom dodavanja proizvoda. Molimo pokušajte ponovo.");
        }
    }


    //Method to reset input fields
    public function resetProduct(): void
    {

        $this->reset([
            'productName', 'productDescription',  'productPrice', 'productDiscount',
            'startDate', 'endDate', 'colorSelect', 'genderSelect', 'heelSelect', 'materialSelect',
            'sizeSelect', 'typeSelect', 'productImage'
        ]);
        $this->isUploading = false;
    }

    //Opening and closing product preview
    public function toggleLightBox(): void
    {
        if ($this->lightBox == false) {


            $this->lightBox = true;
        } else {
            $this->lightBox = false;
        }
    }

    public function render()
    {
        return view('livewire.add-product');
    }
}
