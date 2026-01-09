
    <div class="grid grid-cols-subgrid gap-4 col-span-2 lg:col-span-3 lg2:col-span-4">
    <!--Livewire frontend component - for adding a placeholder image that will be used when no product image is selected-->
    <input wire:model="defaultImage" @if ($errors->has
    ('defaultImage')) class="w-full md:col-span-1 col-span-2 text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded border border-[#D32F2F] w-4/5 sm:w-fit 2xl:w-4/5" @endif class="w-full md:col-span-1 col-span-2 lg2:col-span-1 lg:col-span-2 text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded" accept="image/jpeg, image/png, image/webp" type="file" id="defaultImage"></input>
    @if (session('statusDefault'))
    <!-- Successful insert message -->
    <div class="lg:col-span-2 col-span-2 md:col-span-1 lg2:col-span-1 col-start-1" x-data="{open:true}">
        <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('statusDefault')}}</div>
    </div>
    @endif
    @error('defaultImage')
    <!-- Validation failed message -->
    <span class="col-start-1 lg:col-span-2  error text-[#D32F2F] mt-1">{{ $message }}</span>
    @enderror
    <x-primary-button wire:click="defaultImageUpload" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-1 md:col-span-1 col-span-2 justify-center col-start-1 lg:col-span-2 lg2:col-span-1 lg2:col-start-1">

        {{ __('Ubaci zamjensku sliku') }}

    </x-primary-button>
</div>
