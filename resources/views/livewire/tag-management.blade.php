<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for tag management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center  dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-900 text-white' : ''" @click="red = ! red">
       Oznake proizvoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="100" height="100"><path d="M21.68,9.108L13.204,.723C12.655,.173,11.869-.089,11.098,.013L4.209,.955c-.274,.038-.466,.29-.428,.563,.037,.273,.293,.461,.562,.428l6.889-.942c.46-.066,.934,.095,1.267,.427l8.476,8.385c1.356,1.356,1.363,3.569,.01,4.94l-.19,.199c-.209-.677-.58-1.314-1.114-1.848L11.204,4.723c-.549-.55-1.337-.812-2.106-.709l-6.889,.942c-.228,.031-.404,.213-.43,.44l-.765,6.916c-.083,.759,.179,1.503,.72,2.044l8.417,8.326c.85,.85,1.979,1.318,3.181,1.318h.014c1.208-.004,2.341-.479,3.189-1.339l3.167-3.208c.886-.898,1.317-2.081,1.292-3.257l.708-.743c1.732-1.754,1.724-4.6-.022-6.345Zm-2.688,9.643l-3.167,3.208c-.66,.669-1.542,1.039-2.481,1.042h-.011c-.935,0-1.812-.364-2.476-1.027L2.439,13.646c-.324-.324-.48-.77-.431-1.225l.722-6.528,6.502-.889c.462-.063,.934,.095,1.267,.427l8.476,8.385c1.356,1.356,1.363,3.569,.017,4.934ZM8,10c0,.552-.448,1-1,1s-1-.448-1-1,.448-1,1-1,1,.448,1,1Z"/></svg>

        @foreach ($tags as $index => $tag)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('tags.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="tags.{{ $index }}" placeholder="{{$index +1 }}. New tag" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeTagInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('tags.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addTagInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertTag" class="mt-2">
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
            <x-primary-button wire:click="resetTag" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetTag" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($tagsAll)
            <h3 class="mt-6">Trenutno zastupljene oznake:</h3>
            <!-- Showing Tag categories -->
            <div class="mt-6 grid grid-cols-4 gap-3 gap-x-0 justify-items-center">
                @foreach ($tagsAll as $name)
                <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->tag, $tags)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->tag}}</p><button type="button" wire:click="deleteTagCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                @endforeach
                @endisset
            </div>
        </div>
    </div>