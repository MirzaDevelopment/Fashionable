<div class="flex flex-col items-center " x-data="{ open: false }"> <!-- Livewire frontend component for color management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-900 text-white' : ''" @click="red = ! red">
        Boje
    </button>
    <div class="flex flex-col overflow-auto items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="100" height="100">
            <path d="M21,4v-1.5c0-1.379-1.122-2.5-2.5-2.5H2.5C1.122,0,0,1.121,0,2.5V6.5c0,1.379,1.122,2.5,2.5,2.5H18.5c1.378,0,2.5-1.121,2.5-2.5v-1.5c1.103,0,2,.897,2,2v2c0,1.103-.897,2-2,2h-7.5c-1.93,0-3.5,1.57-3.5,3.5v.55c-1.14,.232-2,1.242-2,2.45v4c0,1.379,1.122,2.5,2.5,2.5s2.5-1.121,2.5-2.5v-4c0-1.208-.86-2.217-2-2.45v-.55c0-1.379,1.122-2.5,2.5-2.5h7.5c1.654,0,3-1.346,3-3v-2c0-1.654-1.346-3-3-3Zm-1,2.5c0,.827-.673,1.5-1.5,1.5H2.5c-.827,0-1.5-.673-1.5-1.5V2.5c0-.827,.673-1.5,1.5-1.5H18.5c.827,0,1.5,.673,1.5,1.5V6.5Zm-8,11v4c0,.827-.673,1.5-1.5,1.5s-1.5-.673-1.5-1.5v-4c0-.827,.673-1.5,1.5-1.5s1.5,.673,1.5,1.5Z" />
        </svg>
        @foreach ($colors as $index => $color)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <p class="flex gap-2 items-center">Pick a color: <input type="color" wire:key="{{ $index }}" wire:model.live="colorPicked.{{$index}}"></input></p>
            <input @if ($errors->has('colors.' . $index) || ($errors->has('colorPicked.' . $index))) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="colors.{{ $index }}" placeholder="{{$index +1 }}. color name" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeColorInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @if ($errors->has('colors.' . $index))
        @error('colors.' . $index)
        <!-- Validation failed message for text part -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @elseif ($errors->has('colorPicked.' . $index))
        @error('colorPicked.' . $index)
        <!-- Validation failed message for color part -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endif
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addColorInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertColor" class="mt-2">
                {{ __('Ubaci') }}
            </x-primary-button>


        </div>
        @if (session('status'))
        <div class="flex flex-col place-content-evenly my-4">
            <!-- Successful insert message -->
            <div x-data="{open:true}">
                <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff]" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetColor" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetColor" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($colorsAll)
            <h3 class="mt-6">Boje koje su trenutno zastupljene:</h3>
            <!-- Showing color categories -->
            <div class="mt-6 grid grid-cols-3 gap-3 gap-x-0 items-center justify-items-center">
                @foreach ($colorsAll as $name)
                <input type="color" value="{{$name->hex_code}}" disabled></input>
                <p class="@if(in_array($name->hex_code, $colorUserPicked))bg-sky-200 @endif p-1 min-w-16 max-w-[6rem] break-words self-center border border-gray-200 rounded-lg shadow">{{$name->color}}</p><button type="button" wire:click="deleteColorCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                @endforeach
                @endisset
            </div>
        </div>

    </div>