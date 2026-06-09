<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Validate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Livewire\WithFileUploads;

class RegisterTenant extends Component
{
    use WithFileUploads;

    //Tenant part
    #[Validate]
    public string $name;
    #[Validate]
    public string $slug;
    #[Validate]
    public int $logoImageId;
    #[Validate]
    public int $coverImageId;
    #[Validate]
    public string $currency = "EUR";
    #[Validate]
    public string $locale = "BS";
    #[Validate]
    public string $email;
    #[Validate]
    public string $phone;
    #[Validate]
    public string $shippingProvider;
    #[Validate]
    public ?string $shippingCost = null;
    #[Validate]
    public ?string $freeShippingThreshold = null;
    #[Validate]
    public string $plan = "free";

    //User part (user will be added with appropriate tenant_id with admin role)
    public string $user_name;
    public string $user_email;
    public string $user_password;


    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\']+( [\p{L}\s\']+)?$/u'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:stores,slug'],
            'logoImageId' => ['integer', 'exists:category_images,id'],
            'coverImageId' => ['integer', 'exists:category_images,id'],

            'currency' => ['required', 'string', 'size:3'],

            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],

            'shippingProvider' => ['string', 'max:255'],

            'shippingCost' => ['numeric', 'min:0'],
            'freeShippingThreshold' => ['nullable', 'numeric', 'min:0'],
            //User validation
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'user_password' => ['required', 'confirmed', Rules\Password::defaults()],

        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Naziv trgovine je obavezan.',

            'slug.required' => 'Slug trgovine je obavezan.',
            'slug.alpha_dash' => 'Slug može sadržavati samo slova, brojeve, crtice i donje crtice.',
            'slug.unique' => 'Ovaj slug se već koristi.',

            'logoImageId.exists' => 'Odabrana logo slika nije ispravna.',

            'coverImageId.exists' => 'Odabrana naslovna slika nije ispravna.',

            'currency.required' => 'Valuta je obavezna.',
            'currency.size' => 'Valuta mora biti važeći ISO kod od 3 slova.',

            'email.required' => 'Email adresa je obavezna.',
            'email.email' => 'Unesite ispravnu email adresu.',

            'phone.required' => 'Broj telefona je obavezan.',

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
            'user_password.confirmed' => 'Potvrda lozinke se ne podudara.',
            'user_password.min' => 'Lozinka mora imati najmanje :min karaktera.',
            'user_password.letters' => 'Lozinka mora sadržavati najmanje jedno slovo.',
            'user_password.mixed_case' => 'Lozinka mora sadržavati velika i mala slova.',
            'user_password.numbers' => 'Lozinka mora sadržavati najmanje jedan broj.',
            'user_password.symbols' => 'Lozinka mora sadržavati najmanje jedan specijalni znak.',


        ];
    }



    public function registerTenant()
    {







    }















    public function render()
    {
        return view('livewire.register-tenant');
    }
}
