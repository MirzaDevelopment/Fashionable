<!--Product stock management view component-->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Manage your product stocks") }}
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="mt-10 mb-10">
        <!--Livewire component for stock management-->
        <livewire:add-product-stock/>
        </div>
    </div>
    <div>
        <x-slot:footerContent>
            <p>Melisa Fashion e-commerce website</p>
            <p>Developed by Mirza Mehagić in Laravel</p>
            <p>Copyright © <?php echo date("Y");?>
            Mirza Mehagić All rights reserved</p>
            <p>This is personal and non-commercial product</p>
            <p>Contact: mirza.mehagic@hotmail.com</p>
            </x-slot>
    </div>
</x-app-layout>