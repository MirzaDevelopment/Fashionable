<x-guest-layout>
    {!! RecaptchaV3::initJs() !!}
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Korisničko ime')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Lozinka')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Potvrdi lozinku')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-6 grid grid-cols-2 items-center justify-items-center mb-[2rem] grid-rows-1 gap-y-[0.5rem]">
            <input class="ml-[8rem]" id="policyCheckbox" type="checkbox" name="policy">
            <label for="policyCheckbox"> Slažem se s <a href="/#footer" class="underline text-cornflowerblue">Uvjetima korištenja i Politikom privatnosti.</a></label>
            @error('policy')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1 col-start-2">{{ $message }}</span>
            @enderror

        </div>
        <!-- Register and recaptcha part -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Već ste registrovani?') }}
            </a>
            {!! RecaptchaV3::field('register') !!}
            <x-primary-button class="ms-4">
                {{ __('Registracija') }}
            </x-primary-button>

        </div>

        </div>
        @if ($errors->has('g-recaptcha-response'))
        <span class="help-block">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
        @endif
    </form>
</x-guest-layout>