<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upravljačka ploča za korisnike') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Dobrodošli") }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center flex-col sm:flex-row gap-4 grid-cols-2 justify-center">
        <div class="p-6 gap-4 flex items-center flex-row gap-4 justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-col items-center">
            <a href="{{ route('wishlist') }}" wire:navigate>
            <img src="{{ asset('storage/images/wishlist-user-icon.svg') }}" alt="wishlist_logo" width="75" height="75"></a>
            <h3>Lista željenih proizvoda</h3>
        </div>
        <div class="flex flex-col items-center">
             <img src="{{ asset('storage/images/finished-items.svg') }}" alt="wishlist_logo" width="75" height="75"></a>
            <h3>Završene kupovine</h3>
            </div>
        </div>
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
    </div>
</x-app-layout>