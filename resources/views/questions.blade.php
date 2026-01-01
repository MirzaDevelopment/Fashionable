<!--Product upload view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Questions from users") }}
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="mt-10 mb-10">
           <p>Questions component will be here</p>
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