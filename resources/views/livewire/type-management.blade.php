<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for type management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center  dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Vrste proizvoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" width="100" height="100" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="M23.5,0c-.276,0-.5,.224-.5,.5v1.5h-7.5c-.827,0-1.5,.673-1.5,1.5v3.5h-4V3.5c0-.276,.224-.5,.5-.5h1c.276,0,.5-.224,.5-.5s-.224-.5-.5-.5h-1c-.827,0-1.5,.673-1.5,1.5v3.5h-1.755c-2.579,0-4.245,1.492-4.245,3.8v.7c0,.827,.673,1.5,1.5,1.5h.5v4.5c0,1.378,1.122,2.5,2.5,2.5h9c1.378,0,2.5-1.122,2.5-2.5v-4.5h.5c.827,0,1.5-.673,1.5-1.5v-.7c0-2.308-1.667-3.8-4.245-3.8h-1.755V3.5c0-.276,.224-.5,.5-.5h7.5V23.5c0,.276,.224,.5,.5,.5s.5-.224,.5-.5V.5c0-.276-.224-.5-.5-.5ZM8.477,8.916c-.508-.14-.942-.466-1.202-.916h1.928c-.299,.259-.534,.571-.726,.916Zm7.744-.916c-.349,.606-.993,1-1.721,1s-1.372-.394-1.721-1h3.442ZM6,17.5v-5c0-.276-.224-.5-.5-.5h-1c-.276,0-.5-.224-.5-.5v-.7c0-1.827,1.227-2.467,2.221-2.687,.334,.835,1.032,1.477,1.891,1.746-.067,.297-.112,.608-.112,.941v.7c0,.827,.673,1.5,1.5,1.5h.5v4.5c0,.565,.195,1.081,.513,1.5h-3.013c-.827,0-1.5-.673-1.5-1.5Zm14-6.7v.7c0,.276-.224,.5-.5,.5h-1c-.276,0-.5,.224-.5,.5v5c0,.827-.673,1.5-1.5,1.5h-4c-.827,0-1.5-.673-1.5-1.5v-5c0-.276-.224-.5-.5-.5h-1c-.276,0-.5-.224-.5-.5v-.7c0-2.137,1.679-2.652,2.699-2.768,.428,1.172,1.529,1.968,2.801,1.968s2.373-.796,2.801-1.968c1.02,.116,2.699,.631,2.699,2.768ZM.996,3V23.5c0,.276-.224,.5-.5,.5S-.004,23.776-.004,23.5V.5C-.004,.224,.22,0,.496,0S.996,.224,.996,.5v1.5H6.5c.276,0,.5,.224,.5,.5s-.224,.5-.5,.5H.996Z" />
        </svg>

        @foreach ($types as $index => $type)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('types.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="types.{{ $index }}" placeholder="{{$index +1 }}. Nova vrsta" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeTypeInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('types.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addTypeInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertType" class="mt-2">
                {{ __('Ubaci') }}
            </x-primary-button>

        </div>
        @if (session('status'))
        <div class="flex flex-col place-content-evenly my-4">
            <!-- Successful insert message -->
            <div x-data="{open:true}">
                <div class="text-[#004085] rounded-md  p-2.5 bg-[#cce5ff]" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetType" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetType" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($typesAll)
            <h3 class="mt-6">Trenutno zastupljene vrste proizvoda:</h3>
            <!-- Showing size categories -->
            <div class="mt-6 grid grid-cols-4 gap-3 gap-x-0 justify-items-center">
                @foreach ($typesAll as $name)
                @if($name->source=="user")
                <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->type_name, $types)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->type_name}}</p><button type="button" wire:click="deleteTypeCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                     @elseif($name->source=="default")
                     <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->type_name, $types)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->type_name}}</p>
                     @endif
                @endforeach
                @endisset
            </div>
        </div>
    </div>