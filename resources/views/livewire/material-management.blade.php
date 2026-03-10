<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for material management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Materijal proizvoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m16,20.063c-1.096.521-2.366.937-4,.937s-2.904-.416-4-.937v-2.398c1.26.721,2.364,1.335,4,1.335s2.74-.614,4-1.335v2.398Zm5-4.063v2h3v-2h-3ZM3,4H0v2h3v-2Zm9,3c-1.636,0-2.74-.614-4-1.335v2.398c1.096.521,2.366.937,4,.937s2.904-.416,4-.937v-2.398c-1.26.721-2.364,1.335-4,1.335Zm9-3v2h3v-2h-3ZM3,16H0v2h3v-2Zm6.5-3.549c-.529-.234-1.037-.52-1.574-.828-1.329-.761-2.836-1.623-4.926-1.623H0v2h3c1.292,0,2.239.541,3.436,1.227.898.514,1.871,1.069,3.064,1.419v-2.194Zm11.5-2.451c-2.09,0-3.597.862-4.926,1.623-.537.308-1.045.594-1.574.828v2.194c1.193-.35,2.166-.905,3.064-1.419,1.197-.686,2.144-1.227,3.436-1.227h3v-2h-3Zm-10,11.939v2.061h2v-2.061c-.32.035-.649.061-1,.061s-.68-.026-1-.061Zm1-11.939c-.351,0-.68-.026-1-.061v7.936c.313.072.637.126,1,.126s.687-.054,1-.126v-7.936c-.32.035-.649.061-1,.061ZM11,0v5.874c.313.072.637.126,1,.126s.687-.054,1-.126V0h-2Zm-5,0h-2v9.066c.735.089,1.393.274,2,.5V0Zm0,14.128c-.019-.011-.042-.022-.061-.033-.752-.43-1.338-.749-1.939-.93v10.835h2v-9.872Zm12,0v9.872h2v-10.835c-.602.181-1.188.5-1.939.93-.019.011-.042.023-.061.034Zm0-14.128v9.566c.607-.226,1.265-.411,2-.5V0h-2Z" />
        </svg>
        @foreach ($materials as $index => $material)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('materials.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="materials.{{ $index }}" placeholder="{{$index +1 }}. Novi materijal" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeMaterialInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('materials.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center  justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addMaterialInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertMaterial" class="mt-2">
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
            <x-primary-button wire:click="resetMaterial" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetMaterial" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($materialsAll)
            <h3 class="mt-6">Trenutno zastupljeni materijali:</h3>
            <!-- Showing material categories -->
            <div class="mt-6 grid grid-cols-4 gap-3 gap-x-0 justify-items-center">
                @foreach ($materialsAll as $name)
                <p class="p-1 min-w-16 max-w-[6rem]  break-words self-center @if(in_array($name->material, $materials)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->material}}</p><button type="button" wire:click="deleteMaterialCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>

                @endforeach
                @endisset
            </div>
        </div>
    </div>