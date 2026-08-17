<!--Product upload view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">{{ __("Dodajte vaš proizvod") }}</p>
                    <p class="text-sm">Ovdje možete dodati proizvode u vašu online prodavnicu i promjeniti zamjensku sliku.</p>
                    <p class="text-sm">Molimo da se po potrebi konsultujete sa vodičem dostupnim <a href="/#footer" class="underline text-cornflowerblue">ovdje.</a></p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="mt-10 mb-10">
            <!--Livewire components for product upload-->
            <livewire:add-product/>
        </div>
    </div>
    <div>
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