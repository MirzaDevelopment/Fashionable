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
            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                <line x1="9" y1="8" x2="15" y2="8" />
                <line x1="9" y1="12" x2="15" y2="12" />
            </svg></a>
            <h3>Lista željenih artikala</h3>
        </div>
        <div class="flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 4h2.8l2.4 10.5a1.6 1.6 0 0 0 1.6 1.3h7.7a1.6 1.6 0 0 0 1.6-1.2l1.9-7.8H7.2" />
                <circle cx="10" cy="19" r="1.6" />
                <circle cx="18" cy="19" r="1.6" />
                <circle cx="18.8" cy="6.2" r="3.8" fill="white" stroke-width="1.6" />
                <path d="M17.9 6.4l0.9 0.9 1.7-1.8" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
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