<!--Edit users view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Promijenite podatke odabranog korisnika") }}
                </div>
            </div>
        </div>
    </div>
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg m-auto">
        <form action="{{ route('users.update', ['user' => $id]) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Ime')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="{{$name}}" value="" autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="{{$email}}" value="" autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <!-- User role -->
                <x-input-label for="role" :value="__('Uloga')" />
                <select name="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="role">
                    <option disabled selected>Promijenite ulogu korisnika</option>
                    <option value="guest">Gost</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mt-8 flex place-content-between">
                <a class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('users') }}" wire:navigate>Back to users</a>

                <x-primary-button class="ms-4">
                    {{ __('Promijeni') }}
                </x-primary-button>
            </div>
            <!-- Successfull user modify message -->
            @if (session('status'))
            <div class="mt-4">
                <div x-data="{open:true}">
                    <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
                </div>
                @endif
        </form>
        <div class="pb-12">
    <x-slot:footerContent>
        <p>Fashionable - software as service (SaaS)</p>
        <p>Melisa Fashion e-commerce website - DEMO</p>
        <p>Fashionable softver nije vlasnik niti vrši prodaju artikala prikazanih ovdje</p>
        <p>Developed by Mirza Mehagić</p>
        <p>Copyright © <?php echo date("Y"); ?></p>
        <p>Mirza Mehagić All rights reserved</p>
        <p>Contact: mirza.mehagic@hotmail.com</p>
        <p> Za pravne dokumente molimo da posjetite: <a href="/#footer" class="underline">Početna stranica</a></p>
        </x-slot>
        </div>
</x-app-layout>