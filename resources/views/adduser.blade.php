<!--User upload view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Provide credentials for the new user") }}
                </div>
            </div>
        </div>
    </div>
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg m-auto">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
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
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div class="mt-4">
                <!-- New user role (guest is by default) -->
                <x-input-label for="role" :value="__('Role')" />
                <select name="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="role">
                    <option value="guest">Guest</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex items-center justify-end mt-4">

                <a class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dashboard') }}" wire:navigate>Back</a>
                <x-primary-button class="ms-4">
                    {{ __('Add') }}
                </x-primary-button>
            </div>
            <!-- Successfull user add message -->
            @if (session('status'))
            <div class="flex place-content-evenly my-4">
                <div x-data="{open:true}">
                    <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
                </div>
                @endif
        </form>
        <x-slot:footerContent>
            <p>Melisa Fashion e-commerce website</p>
            <p>Developed by Mirza Mehagić in Laravel</p>
            <p>Copyright © <?php echo date("Y");?>
            Mirza Mehagić All rights reserved</p>
            <p>This is personal and non-commercial product</p>
            <p>Contact: mirza.mehagic@hotmail.com</p>
            </x-slot>
    </div>
</x-app-layout>