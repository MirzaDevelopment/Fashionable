<div> <!--Livewire frontend component with input fields for editing product general info-->
    <div class="mt-10 bg-white">
        <!--Product general info section-->
        <section class="p-6 mt-10 min-h-[731px] place-content-evenly bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
            <h2 class="text-xl">1. Opšti podaci o proizvodu</h2>
            <hr>
            <label class="font-medium" for="productName">Trenutno ime proizvoda.</label>
            <input wire:model="productName" @if ($errors->has('productName')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="productName" value="{{$productName}}" type="text" name="productName" required autofocus autocomplete="name"/>
            @error('productName')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <label class="font-medium" for="productDescription">Trenutni opis proizvoda.</label>
            <textarea wire:model.blur="productDescription" id="productDescription" @if ($errors->has('productDescription')) class="border-[#D32F2F]" @endif class="min-h-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$productDescription}}"></textarea>
            @error('productDescription')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Edit product general info -->
            <x-primary-button wire:click="editProduct" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

                {{ __('Promijeni opšte podatke') }}

            </x-primary-button>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetGeneralInfo" class="justify-center mt-2 xl:col-span-1 lg2:col-span-1 lg2:col-start-4">
                {{ __('Očisti polja') }}
            </x-primary-button>
        </section>
        <!--Back and submit product buttons section-->
        <section class="mt-10 grid grid-cols-subgrid gap-4 col-span-2 lg2:col-span-4">
            @if (session('status'))
            <!-- Successful insert message -->
            <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
                <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
            </div>
            @elseif(session('errorException'))
            <!-- Failed insert message -->
            <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            @endif
        </section>

    </div>
</div>