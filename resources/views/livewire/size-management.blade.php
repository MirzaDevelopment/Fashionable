<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for size management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-900 text-white' : ''" @click="red = ! red">
        Veličine
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" width=100 height=100 data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m9.5,9c2.236,0,4.5-.687,4.5-2,0-2.627-9-2.627-9,0,0,1.313,2.264,2,4.5,2Zm0-3c2.273,0,3.5.71,3.5,1s-1.227,1-3.5,1-3.5-.71-3.5-1,1.227-1,3.5-1Zm11,6h-1.5v-5c0-3.309-4.262-6-9.5-6C4.672,1,.683,3.288.086,6.236c-.05.078-.086.165-.086.264v11.286c0,2.924,3.901,5.214,8.881,5.214h11.619c1.93,0,3.5-1.57,3.5-3.5v-4c0-1.93-1.57-3.5-3.5-3.5Zm-2.5,0h-3.26c1.387-.582,2.513-1.389,3.26-2.336v2.336ZM9.5,2c4.687,0,8.5,2.243,8.5,5s-3.813,5-8.5,5S1,9.757,1,7,4.813,2,9.5,2Zm13.5,17.5c0,1.379-1.121,2.5-2.5,2.5h-.5v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-3v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-3v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-2.119c-.298,0-.591-.011-.881-.03v-4.47c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.368c-3.398-.465-6-2.143-6-4.082v-8.123c1.557,1.974,4.777,3.336,8.5,3.336h11c1.379,0,2.5,1.121,2.5,2.5v4Z" />
        </svg>

        @foreach ($sizes as $index => $size)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('sizes.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="sizes.{{ $index }}" placeholder="{{$index +1 }}. Nova veličina" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeSizeInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('sizes.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addSizeInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertSize" class="mt-2">
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
            <x-primary-button wire:click="resetSize" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetSize" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($sizesAll)
            <h3 class="mt-6">Trenutno zastupljene veličine:</h3>
            <!-- Showing size categories -->
            <div class="mt-6 grid grid-cols-4 gap-3 gap-x-0 justify-items-center">
                @foreach ($sizesAll as $name)
                <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->size, $sizes)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->size}}</p><button type="button" wire:click="deleteSizeCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                @endforeach
                @endisset
            </div>
        </div>
    </div>