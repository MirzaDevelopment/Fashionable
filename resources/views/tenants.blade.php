<x-superadmin-layout><!--Tenants view component-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <p class="mb-2 text-base">{{ __("Registrovani zakupci") }}</p>
                    <p class="text-sm">Ovdje možete pretraživati, brisati i mijenjati zakupce.</p>
                </div>
            </div>
        </div>
    </div>
    <!--Livewire component for showing tenants-->
    <livewire:show-tenants />
</x-superadmin-layout>