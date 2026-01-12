<!--Edit products view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Ažurirajte vaš proizvod") }}
                </div>
            </div>
        </div>
    </div>
    <div class="sm:grid grid-cols-2 gap-x-2 lg:grid-cols-4 gap-y-6 w-full px-6 py-4 bg-white overflow-hidden sm:rounded-lg m-auto mt-10 mb-10">
        <!--Livewire components for edit product (general info, price and discounts)-->
        <livewire:edit-product-general-info />
        <livewire:edit-product-price />
        <div class="p-6 mt-10 overflow-auto max-h-[731px] sm:col-span-2 lg2:col-span-1 bg-white sm:grid-cols-subgrid gap-4 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
            <h2 class="text-xl">3. Kategorije proizvoda i oznake</h2>
            <hr>
            <p class="font-medium">Odaberite kategoriju i oznaku za vaš proizvod.</p>
            <div class="sm:grid grid-cols-2 gap-6 w-full bg-white">
                <!--Livewire components for edit product (categories)-->
                <livewire:edit-product-material />
                <livewire:edit-product-type />
                <livewire:edit-product-heel />
                <livewire:edit-product-color />
                <livewire:edit-product-gender />
                <livewire:edit-product-size />
                <livewire:edit-product-tag />
            </div>
        </div>
        <section class="p-6  mt-10 max-h-[731px] sm:col-span-2 lg2:col-span-1 sm:grid-cols-subgrid gap-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
            <h2 class="text-xl">4. Slike proizvoda</h2>
            <hr>
            <label class="font-medium" for="productImage">Trenutne slike za odabrani proizvod.</label>
            <div class="overflow-scroll lg2:overflow-auto flex flex-col gap-6">
                <p class="text-xs text-gray-400">PNG, JPG SVG, WEBP, and GIF su dopuštene.</p>
                <p class="text-xs text-gray-400">Upozorenje: dodavanja nove slike, zahtjeva da se prvo odabere boja za pripadajuću sliku.</p>
                <!--Livewire components for edit product (images)-->
                <livewire:edit-product-image />
            </div>
        </section>
        <section class="mt-10 grid grid-cols-subgrid gap-4 col-span-2 lg:col-span-4 lg2:col-span-4">
            <a class="col-start-1 lg2:col-start-1 lg:col-span-2 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('products') }}" wire:navigate>Back to products</a>
            <a class="col-start-2 lg:col-span-2 lg2:col-start-4 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="/stock-management/{{ request('id') }}?route=update" wire:navigate>Update product stocks</a>
            <!-- Reloading page button with js -->
            <x-primary-button onclick="location.reload();" class="justify-center xl:col-span-2 col-start-2 lg:col-start-3 lg:col-span-2 lg2:col-span-1 lg2:col-start-4 xl:col-start-3">
                {{ __('Osvježi podatke stranice') }}
            </x-primary-button>
        </section>
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