<div class="flex flex-col items-center" x-data="{ open: false }"> <!-- Livewire frontend component for gender management - delete and insert -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center  dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Vrste spolova
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" height="100" width="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m9.803,15.484c.215.173.25.487.078.703l-1.87,2.337c-.485.606-1.498.605-1.982,0l-1.883-2.354c-.141-.176-.393-.213-.576-.087-1.609,1.124-2.569,2.961-2.569,4.917v2.5c0,.276-.224.5-.5.5S0,23.776,0,23.5v-2.5C0,18.718,1.121,16.573,2.998,15.263c.612-.428,1.459-.305,1.929.282l1.883,2.354c.139.174.278.176.421,0l1.869-2.337c.173-.214.487-.25.703-.078Zm11.231-.2c-.613-.434-1.463-.312-1.935.278l-1.869,2.337c-.143.176-.282.174-.421,0l-1.883-2.354c-.469-.586-1.316-.709-1.929-.282-1.876,1.31-2.997,3.455-2.997,5.737v2.5c0,.276.224.5.5.5s.5-.224.5-.5v-2.5c0-1.956.96-3.793,2.569-4.917.182-.126.436-.089.576.087l1.883,2.354c.484.605,1.497.606,1.982,0l1.87-2.337c.141-.177.393-.214.576-.086,1.593,1.125,2.543,2.957,2.543,4.899v2.5c0,.276.224.5.5.5s.5-.224.5-.5v-2.5c0-2.268-1.109-4.404-2.966-5.716ZM0,14.5c0-.039.014-.113.014-.113C.014,14.387,2.009,5.799,2.075,5.522,2.807,2.459,4.878.454,7.577.079c.302-.047.608-.079.923-.079,1.661,0,3.143.594,4.313,1.71,1.082-1.056,2.559-1.71,4.187-1.71,3.309,0,6,2.691,6,6s-2.691,6-6,6-6-2.691-6-6c0-1.317.432-2.533,1.154-3.523-.261-.253-.541-.474-.838-.663-.935,2.981-3.642,5.091-6.801,5.183h-.914c.464,2.281,2.484,4.003,4.899,4.003.628,0,1.24-.115,1.818-.341.257-.102.547.026.648.284s-.027.547-.284.648c-.696.271-1.43.409-2.183.409-2.832,0-5.205-1.973-5.832-4.616-.596,2.56-1.69,7.227-1.69,7.227-.052.221-.241.389-.478.389-.276,0-.5-.224-.5-.5ZM12,6c0,2.757,2.243,5,5,5s5-2.243,5-5-2.243-5-5-5-5,2.243-5,5Zm-8.5-.001h.999c2.773-.083,5.157-1.978,5.916-4.64-.596-.228-1.235-.359-1.915-.359-2.756,0-4.999,2.242-5,4.999Z" />
        </svg>
        @foreach ($genders as $index => $gender)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('genders.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="genders.{{ $index }}" placeholder="{{$index +1 }}. Novi spol" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeGenderInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('genders.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addGenderInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertGender" class="mt-2">
                {{ __('Ubaci') }}
            </x-primary-button>

        </div>
        @if (session('status'))
        <div class="flex flex-col place-content-evenly items-center my-4">
            <!-- Successful insert message -->
            <div x-data="{open:true}">
                <div class="text-[#004085] rounded-md w-60 p-2.5 bg-[#cce5ff]" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetGender" class="mt-2 w-60">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            @if ($messageD)
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ $messageD }}
            </div>
            @endif
            <!-- Resetting input -->
            <x-primary-button wire:click="resetGender" class="mt-2 w-60">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($gendersAll)
            <h3 class="mt-6">Trenutno zastupljeni spolovi:</h3>
            <p class="text-xs text-gray-400">Spolovi sa oznakom katanca su ugrađeni i nije ih moguće brisati</p>
            <!-- Showing gender categories -->
            <div class="mt-6 grid grid-cols-2 gap-3 gap-x-0 items-center justify-items-center">
                @foreach ($gendersAll as $name)
                @if($name->source=="user")
                <p class="p-1 min-w-16 max-w-[6rem]  break-words self-center @if(in_array($name->gender, $tidyGenders)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->gender}}</p><button type="button" wire:click="deleteGenderCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                @elseif($name->source=="default")
                <p class="p-1 min-w-16 max-w-[6rem]  break-words self-center @if(in_array($name->gender, $tidyGenders)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->gender}}</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#000">
                    <path d="M17 9h-1V7a4 4 0 10-8 0v2H7a2 2 0 00-2 2v9a2 2 0 002 2h10a2 2 0 002-2v-9a2 2 0 00-2-2zm-7-2a2 2 0 114 0v2h-4V7z" />
                </svg>
                @endif
                @endforeach
                @endisset
            </div>
        </div>
    </div>