<!--Users view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="text-lg p-6 text-gray-900">
                    {{ __("Registered users") }}
                </div>
            </div>
        </div>
    </div>
    <!--Livewire component for showing users in db-->
    <livewire:show-users />
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