<div class="flex flex-col items-center"  x-data="{ open: false }"> <!--Frontend component for rendering present image categories for chosen product-->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Slike proizvoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <h3 class="mt-6">Promijeni slike proizvoda:</h3>
        <!-- Showing image categories -->
        <div  class="mt-6 grid grid-cols-1 gap-2 gap-x-10 justify-items-center">
            @foreach ($imageNames as $index => $name)
            @if($productImage)
            @foreach ($productImage as $index => $productImage)
            @if (!$errors->has
            ('productImage.'.$index))
            <img wire:key="{{$index}}" src="{{ $productImage->temporaryUrl()}}" width="320"  />
            <h3>Boja povezana sa slikom:</h3>
            <p class="text-xl text-gray-900 dark:text-white">{{$colorNames[$index]}}</p>
            <input type="color" value="{{$hexCode[$index]}}" disabled></input>
            <input wire:model="productImage.{{ $index }}" class="invisible absolute" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp" type="file" id="fileInput-{{$index}}">
            @endif
            @error('productImage.'.$index)
            <!-- Validation failed message -->
            <span  @if ($errors->has
            ('productImage.'.$index)) class="error text-[#D32F2F] p-2 mt-1 border border-[#D32F2F] w-4/5 sm:w-fit 2xl:w-4/5" @endif>{{ $message }}</span>
            @enderror
            @endforeach
            @else
            <input wire:model="productImage.{{ $index }}" wire:click="selectImageName('{{$name}}')" class="invisible" accept="image/jpeg, image/png, image/webp" type="file" id="fileInput-{{$index}}">
            <img class="cursor-pointer"wire:key="{{$index}}" src="{{asset('storage/'.$name)}}" width="320" height="auto" alt="product_image" onclick="document.getElementById('fileInput-{{$index}}').click();"></img>
            <h3>Boja povezana sa slikom:</h3>
            <p class="text-xl text-gray-900 dark:text-white">{{$colorNames[$index]}}</p>
            <input type="color" value="{{$hexCode[$index]}}" disabled></input>

            @endif
            @endforeach

        </div>

        <section class="mt-2">
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
        @elseif(session('errorImages'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorImages')}}</div>
        </div>
        @elseif(session('emptyImages'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('emptyImages')}}</div>
        </div>
        @endif
    </section>
        <div class="mt-3">
    <x-primary-button wire:click="editImage" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

        {{ __('Ažuriraj') }}

    </x-primary-button>
    </div>
    </div>
</div>