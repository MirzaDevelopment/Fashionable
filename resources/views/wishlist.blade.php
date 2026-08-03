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
                    {{ __("Lista željenih proizvoda") }}
                </div>
                <p>Poslaćemo Vam email obaviještenje kada neki od ovih proizvoda bude na popustu.</p>
            </div>
        </div>
    </div>
    <!--Livewire regular component that renders wishlisted items-->
    <livewire:show-user-wishlist />
    <div class="pb-12">
        <!--Footer part is here-->
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