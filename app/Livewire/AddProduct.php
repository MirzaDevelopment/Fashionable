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
    public ?float $productPrice=null;
    #[Validate]
    public ?float $productDiscount=null;
    #[Validate]
    public ?string $startDate=null;
    #[Validate]
    public ?string $endDate=null;
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
  

    /*
    Categories select
    */

    //Visual change of selected colors
    public function ColorSelect(string $parameter):void
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
    public function GenderSelect(string $parameter):void
    {

        if (in_array($parameter, $this->genderSelect)) {
            $index = array_search($parameter, $this->genderSelect);
            unset($this->genderSelect[$index]);
        } else {
            $this->genderSelect[] = $parameter;
        }
    }

    //Visual change of selected tags
    public function TagSelect(string $parameter):void
    {

        if (in_array($parameter, $this->tagSelect)) {
            $index = array_search($parameter, $this->tagSelect);
            unset($this->tagSelect[$index]);
        } else {
            $this->tagSelect[] = $parameter;
        }
    }

    //Visual change of selected Heels
    public function HeelSelect(string $parameter):void
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
            session()->flash('errorHeel', 'Please select only one heel type!');
        };
    }


    //Visual change of selected materials
    public function MaterialSelect(string $parameter):void
    {

        if (in_array($parameter, $this->materialSelect)) {
            $index = array_search($parameter, $this->materialSelect);
            unset($this->materialSelect[$index]);
        } else {


            $this->materialSelect[] = $parameter;
        }
    }

    //Visual change of selected sizes
    public function SizeSelect(string $parameter):void
    {

        if (in_array($parameter, $this->sizeSelect)) {
            $index = array_search($parameter, $this->sizeSelect);
            unset($this->sizeSelect[$index]);
        } else {
            $this->sizeSelect[] = $parameter;
        }
    }

    //Visual change of selected product types
    public function TypeSelect(string $parameter):void
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
            session()->flash('errorType', 'Please select only one product type!');
        };
    }

    /*
    Price and discount manipulation
    */
    public function updatedproductDiscount():void
    {
        //Logic to display discounted price for the admin.
        if ($this->productDiscount) {

            $this->productDiscountedPrice = ($this->productPrice) - ($this->productPrice * $this->productDiscount / 100);
        } else if (empty($this->productDiscount)) {
            $this->productDiscount = null;
        }
    }
    //Resetting discount precentage to empty if price is changed 
    public function updatedproductPrice():void
    {
        unset($this->productDiscount);
    }

    /*
    Validation
    */
    protected function rules():array
    {

        $rules = [
            //Product name validation
            'productName' => "required|min:3|string|regex:/^[A-Za-z\s']+( [A-Za-z\s']+)?$/",
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
        'productName.required' => 'Please provide a product name.',
        'productName.string' => 'Product name must contain only letters.',
        'productName.min' => 'Product name must contain at least three letters.',
        'productName.regex' => 'Product name must contain only letters.',
        //Product description validation messages
        'productDescription.required' => 'Please provide a product description.',
        'productDescription.string' => 'Product name must be valid string.',
        'productDescription.min' => 'The product description must be at least 10 characters.',
        'productDescription.max' => 'The product description must not exceed 1000 characters.',
        //Product Price validation messages
        'productPrice.required' => 'Starting product price is required.',
        'productPrice.numeric' => 'Product price must be a number.',
        'productPrice.regex' => 'The price must be a valid number with two decimal places (e.g., 25.45, 100.00).',
        'product_price.gt' => 'The price must be greater than 0.',
        //Product discount validation messages
        'productDiscount.numeric' => 'The discount must be a valid number.',
        'productDiscount.between' => 'The discount percentage must be between 0 and 100.',
        'productDiscount.regex' => 'The discount must be a valid number with up to two decimal places.',
        //Discount start and end date validation messages
        'startDate' => 'The provided discount start date is not valid.',
        'endDate' => 'The provided discount end date is not valid.',
        //Category select validation messages
        'colorSelect.required' => 'Please choose a color for your product',
        'genderSelect.required' => 'Please choose appropriate gender for your product',
        'typeSelect.required' => 'Please choose product type',
        'materialSelect.required' => 'Please select your product material',
        'sizeSelect.required' => 'Please choose a size for your product',
        //Product image upload validation messages
        'productImage.*.required' => 'Product image is required.',
        'productImage.*.image' => 'Wrong file uploaded! The uploaded file must be an image.',
        'productImage.*.mimes' => 'Wrong image type uploaded! The image must be a file of type: jpeg, webp, png, jpg, gif, svg.',
        'productImage.*.max' => 'Wrong file size! The image size must be less than 1MB.',
        'productImage.*.dimensions' => 'Wrong file dimensions! The image dimensions must be between 300x300 and 1200x1200.',

    ];

    //Real life validation of image
    public function updatedproductImage():void
    {
        $this->validateOnly("productImage.*");
    }


    /*
    Product insert
    */
    public function uploadProduct():?RedirectResponse
    {
       Gate::authorize('create', Product::class);
        /*
        General preparations
        */
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }


        $this->validate();
        //Making sure both discount and dates are selected
        if (!(empty($this->productDiscount)) && empty($this->startDate) && empty($this->endDate)) {

            return session()->flash('errorDates', 'Please select start and end date for your discount!');
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
                $image_200x200 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 200)->encode(new WebpEncoder(quality: 80));
                $image_400x400 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 400)->encode(new WebpEncoder(quality: 80));
                $image_800x800 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 800)->encode(new WebpEncoder(quality: 80));
                $image_1200x1200 = $manager->read(storage_path("app/public/{$realPath}"))->scale(width: 1200)->encode(new WebpEncoder(quality: 80));
                //Saving in appropriate path
                $image_200x200->save(storage_path("app/public/images/200x200/{$hashedWebPName}"));
                $image_400x400->save(storage_path("app/public/images/400x400/{$hashedWebPName}"));
                $image_800x800->save(storage_path("app/public/images/800x800/{$hashedWebPName}"));
                $image_1200x1200->save(storage_path("app/public/images/1200x1200/{$hashedWebPName}"));
                //Finally saving the path to database
                $imageIdArray[] = Image::create([
                    'image_path' => $realPath, //Default image size
                    'image_200x200' => 'images/200x200/' . $hashedWebPName,
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
              
             $product->colorsVariant()->attach($ids, ['category_size_id'=>  $idsSizes]);
               
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



            /*
        Part IV - return message
        */
            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("status", "Your product added successfully!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "There was an issue adding the product. Please try again.");
        }
    }


    //Method to reset input fields
    public function resetProduct():void
    {

        $this->reset([
            'productName', 'productDescription',  'productPrice', 'productDiscount',
            'startDate', 'endDate', 'colorSelect', 'genderSelect', 'heelSelect', 'materialSelect',
            'sizeSelect', 'typeSelect', 'productImage'
        ]);
        $this->isUploading = false;
    }

    //Opening and closing product preview
    public function toggleLightBox():void
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
