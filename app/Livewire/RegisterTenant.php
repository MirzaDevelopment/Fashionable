<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Livewire\WithFileUploads;

class RegisterTenant extends Component
{
    use WithFileUploads;

    //Tenant part
    public bool $isUploading = false; //Toggle property to prevet form submit spam
    #[Validate]
    public string $tenantName;
    #[Validate]
    public string $slug;
    #[Validate]
    public ?object $logoImage = null;
    #[Validate]
    public ?object $coverImage = null;
    #[Validate]
    public string $currency = "EUR";
    #[Validate]
    public string $locale = "BS";
    #[Validate]
    public string $phone;
    #[Validate]
    public string $shippingProvider;
    #[Validate]
    public string $shippingProviderOther;
    #[Validate]
    public $shippingCost = null;
    #[Validate]
    public $freeShippingThreshold = null;
    #[Validate]
    public string $plan = "free";

    //User part (user will be added with appropriate tenant_id with admin role)
    public string $user_name;
    public string $user_email;
    public string $user_password;
    public string $user_password_confirmation;


    protected function rules(): array
    {
        return [
            //Tenant validation
            'tenantName' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\']+( [\p{L}\s\']+)?$/u'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:tenants,slug'],

            'logoImage' => [
                'nullable',
                'mimes:svg,png,webp,jpg,jpeg',
                'max:512',
            ],
            'coverImage' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                'dimensions:min_width=1200,min_height=630',
            ],
            'currency' => ['required', 'in:EUR,BAM,RSD'],

            'phone' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'regex:/^\+[0-9][0-9\s]{7,19}$/',
            ],

            'shippingProviderOther' => ['nullable', 'string', 'max:255', 'required_if:shippingProvider,other'],

            'shippingCost' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'freeShippingThreshold' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            //User validation
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'g-recaptcha-response' => 'required|recaptchav3:register,0.5',
            'user_password' => ['required', 'confirmed', Rules\Password::defaults()],

        ];
    }

    protected function messages(): array
    {
        return [
            'tenantName.required' => 'Unesite naziv.',
            'tenantName.string'   => 'Naziv mora biti ispravno unesen kao tekst.',
            'tenantName.max'      => 'Naziv ne može biti duži od 255 karaktera.',
            'tenantName.regex'    => 'Naziv može sadržavati samo slova, razmake i apostrof te se može sastojati od najviše dvije riječi.',
            'slug.required' => 'URL trgovine je obavezan.',
            'slug.alpha_dash' => 'URL može sadržavati samo slova, brojeve, crtice i donje crtice.',
            'slug.unique' => 'Ovaj URL se već koristi.',


            'logoImage.mimes' => 'Podržani formati logotipa su SVG, PNG, WebP, jpg, jpeg.',
            'logoImage.max' => 'Veličina logotipa ne smije prelaziti 512 KB.',

            'coverImage.image' => 'Molimo odaberite sliku.',
            'coverImage.mimes' => 'Podržani formati: JPG, JPEG, PNG i WEBP.',
            'coverImage.max' => 'Slika može biti maksimalno 2 MB.',
            'coverImage.dimensions' => 'Minimalna veličina slike je 1200×630 px.',

            'currency.required' => 'Valuta je obavezna.',

            'phone.required' => 'Broj telefona je obavezan.',
            'phone.min' => 'Unesite ispravan broj telefona (minimum osam cifara)',
            'phone.regex' => 'Broj telefona mora biti u obliku +387 xx xxx xxx.',

            'shippingProviderOther.required_if' => 'Molimo da unesete naziv dostavljača.',
            'shippingProviderOther.max' => 'Naziv je predugačak (max 255 karaktera).',

            'shippingCost.required' => 'Cijena dostave je obavezna.',
            'shippingCost.numeric' => 'Cijena dostave mora biti broj.',
            'shippingCost.min' => 'Cijena dostave ne može biti negativna.',

            'freeShippingThreshold.numeric' => 'Prag za besplatnu dostavu mora biti broj.',
            'freeShippingThreshold.min' => 'Prag za besplatnu dostavu ne može biti negativan.',

            //User message validation starts here
            'user_name.required' => 'Ime je obavezno.',
            'user_name.string' => 'Ime mora biti tekst.',
            'user_name.max' => 'Ime ne smije imati više od 255 karaktera.',

            'user_email.required' => 'Email adresa je obavezna.',
            'user_email.string' => 'Email adresa mora biti tekst.',
            'user_email.lowercase' => 'Email adresa mora biti napisana malim slovima.',
            'user_email.email' => 'Unesite ispravnu email adresu.',
            'user_email.max' => 'Email adresa ne smije imati više od 255 karaktera.',
            'user_email.unique' => 'Ova email adresa je već registrovana.',

            'user_password.required' => 'Lozinka je obavezna.',
            'user_password.confirmed' => 'Lozinke se ne podudaraju.',
            'user_password.min' => 'Lozinka mora imati najmanje :min karaktera.',
            'user_password.letters' => 'Lozinka mora sadržavati najmanje jedno slovo.',
            'user_password.mixed_case' => 'Lozinka mora sadržavati velika i mala slova.',
            'user_password.numbers' => 'Lozinka mora sadržavati najmanje jedan broj.',
            'user_password.symbols' => 'Lozinka mora sadržavati najmanje jedan specijalni znak.',


        ];
    }



    public function registerTenant()
    {
        if ($this->isUploading) {
            return null; // Prevent further submissions if already uploading
        }

        $this->validate();

        //Beginning transaction
        DB::beginTransaction();
        try {
            //Inserting tenant logo in category_images table and on
            $logoPath = ($this->logoImage);
            //ImageManager class instance
            $manager = new ImageManager(Driver::class);
           

            $RawName = $logoPath->getClientOriginalName();
            //Store the original default size image
            $realPath = $logoPath->store("images", "public");
            //Hash the new resized name
            $hashedWebPName = md5(time() . $RawName) . ".webp";
            //Using intervention package to resize and encode to webP
            $image_200x200 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 200)->encode(new WebpEncoder(quality: 80));
            $image_400x400 = $manager->read(storage_path("app/public/{$realPath}"))->scaleDown(width: 400)->encode(new WebpEncoder(quality: 80));

            //Saving in appropriate path
            $image_200x200->save(storage_path("app/public/images/200x200/{$hashedWebPName}"));
            $image_400x400->save(storage_path("app/public/images/400x400/{$hashedWebPName}"));

            //Finally saving the path to database
            $logoImage = Image::create([
                'image_path'=>"logo",
                'image_path' => $realPath, //Default image size
                'image_320x320' => null,
                'image_400x400' => 'images/400x400/' . $hashedWebPName,
                'image_800x800' => null,
                'image_1200x1200' => null,

            ]);


            //Inserting into tenant table
            $tenant = Tenant::create([
                'tenant_name' => ucfirst($this->tenantName),
                'slug' => $this->slug,
                'logo_image_id' => $logoImage->id,
                'cover_image_id' => $coverImageId,
                'currency' => $this->curency,
                'phone' => $this->phone,
                'shipping_provider' => $this->shippingProvider, //Or shippingProviderOther
                'shipping_cost' => $this->shippingCost,
                'free_shipping_threshold' => $this->freeShippingThreshold


            ]);

            $user = User::create([
                'name' => $this->user_name,
                'email' => $this->user_email,
                'password' => Hash::make($this->user_password),
                'role' => 'admin',
                'tenant_id' => $tenant->id
            ]);


            DB::commit();
            $this->isUploading = true;
            return redirect()->back()->with("statusTenant", "Vaša prodavnica je uspješno kreirana!");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            $this->isUploading = false;
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with("errorException", "Nastao je problem prilikom kreiranja prodavnice. Molimo pokušajte ponovo.");
        }
    }













    public function render()
    {
        return view('livewire.register-tenant');
    }
}
