<div><!--Livewire frontend component with input fields for editing product prices and discount info-->
    <div class="mt-10 bg-white">
        <!--Prices and discount section-->
        <section class="p-6 mt-10 min-h-[731px] place-content-evenly max-h-[731px] lg:overflow-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
            <h2 class="text-xl">2. Cijene i popusti proizvoda</h2>
            <hr>
            <label class="font-medium" for="productPrice">Trenutna cijena proizvoda</label>
            <input wire:model.blur="productPrice" id="productPrice" type="number" min="0" @if ($errors->has('productPrice')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$productPrice}}">
            @error('productPrice')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <label class="font-medium" for="productDiscount">Trenutni popust cijene.</label>
            <input wire:model.blur="productDiscount" id="productDiscount" type="number" min="0" @if ($errors->has('productDiscount')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$productDiscount}}" >
            @error('productDiscount')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <label class="font-medium" for="productDiscount">Trenutni početak i kraj popusta cijene.</label>
            <input id="startDate" wire:model.blur="startDate" @if(empty($productDiscount)) class="opacity-[.25]" disabled @endif type="date" @if ($errors->has('startDate')) class="border-[#D32F2F]" @endif id="startDate" name="startDate" value="" min="2018-01-01" />
            @if($startDate)<label class="font-medium opacity-[0.25]" for="startDate">Active start date: {{date('d-m-Y', strtotime($startDate))}}</label>@endif
            @error('startDate')

            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            @if (session('errorDates'))
            <div class="text-[#D32F2F] mt-2">
                {{ session('errorDates') }}
            </div>
            @endif
            <input id="endDate" wire:model.blur="endDate" @if(empty($productDiscount)) class="opacity-[.25]" disabled @endif type="date" @if ($errors->has('endDateName')) class="border-[#D32F2F]" @endif id="endDate" name="endDate" value="" min="2018-01-01" />
            @if($startDate)<label class="font-medium opacity-[0.25]" for="endDate">Active end date: {{date('d-m-Y', strtotime($endDate))}}</label>@endif
            @error('endDate')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Empty dates if discount is selected message -->
            @if (session('errorDates'))
            <div class="text-[#D32F2F] mt-2">
                {{ session('errorDates') }}
            </div>
            @endif
            <x-primary-button wire:click="editPrice" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

                {{ __('Promijeni cijenu i popust') }}
            </x-primary-button>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetPrice" class="justify-center mt-2 xl:col-span-1 lg2:col-span-1 lg2:col-start-4">
                {{ __('Očisti polja') }}
            </x-primary-button>
        </section>
        <!--Messages-->
        <section class="mt-10 grid grid-cols-subgrid gap-4 col-span-2 lg:col-span-4 lg2:col-span-4">
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