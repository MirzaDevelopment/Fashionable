<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 flex">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
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