<!--Category management view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Category management") }}
                </div>
            </div>
        </div>
    </div>
    <div class="sm:grid grid-cols-2 lg:grid-cols-3 gap-6 w-full sm:max-w-fit px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg m-auto">
        <div class="mt-10 mb-10">
            <!--Livewire components for material, type, color, heel, gender, tag, size-->
            <livewire:material-management />
        </div>
        <div class="mt-10 mb-10">
            <livewire:type-management />
        </div>
        <div class="mt-10 mb-10">
            <livewire:heel-management />
        </div>
        <div class="sm:col-span-2 md:col-span-1 mt-10 mb-10">
            <livewire:color-management />
        </div>
        <div class="mt-10 mb-10">
            <livewire:gender-management />
        </div>
        <div class="mt-10 mb-10">
            <livewire:tag-management />
        </div>
        <div class="mt-10 mb-10">
            <livewire:size-management />
        </div>
        <a class="col-start-1 col-span-1 lg:col-start-1 lg2:col-start-1 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dashboard') }}" wire:navigate>Back to Dashboard</a>
    </div>
    <div class="pb-12">
        <x-slot:footerContent>
            <p>Melisa Fashion e-commerce website</p>
            <p>Developed by Mirza Mehagić in Laravel</p>
            <p>Copyright © <?php echo date("Y"); ?>
                Mirza Mehagić All rights reserved</p>
            <p>This is personal and non-commercial product</p>
            <p>Contact: mirza.mehagic@hotmail.com</p>
            </x-slot>
    </div>
</x-app-layout>