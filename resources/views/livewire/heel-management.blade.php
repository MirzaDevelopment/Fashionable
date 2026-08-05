<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for  general heel category management - delete and insert (not associated with products) -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
       Vrste peti
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m20.776,16.213l-6.897-3.135c-.534-.243-.879-.778-.879-1.365V3.501c0-1.053-.467-2.039-1.281-2.707-.814-.668-1.872-.931-2.906-.726L2.813,1.269c-1.63.326-2.813,1.769-2.813,3.432v17.299c0,1.103.897,2,2,2h4c1.103,0,2-.897,2-2v-1.705c.279.122.543.28.783.472l2.809,2.247c.795.636,1.793.986,2.812.986h6.816c1.533,0,2.78-1.247,2.78-2.78,0-2.152-1.266-4.117-3.224-5.007Zm-13.776,5.787c0,.551-.449,1-1,1H2c-.551,0-1-.449-1-1v-2h5.597c.135,0,.27.009.403.024v1.976Zm14.22,1h-6.816c-.792,0-1.568-.272-2.187-.767l-2.809-2.247c-.795-.636-1.793-.986-2.812-.986H1V4.701c0-1.188.845-2.219,2.01-2.452l2.99-.598v9.849c0,.276.224.5.5.5s.5-.224.5-.5V1.5c0-.016,0-.032-.002-.048l2.012-.403c.737-.146,1.493.041,2.075.519.582.477.915,1.181.915,1.933v8.211c0,.978.575,1.871,1.465,2.275l6.896,3.135c1.603.728,2.638,2.336,2.638,4.097,0,.981-.799,1.78-1.78,1.78Z" />
        </svg>

        @foreach ($heels as $index => $heel)
        <!-- Category insert inputs -->
        <div class="flex flex-col-reverse gap-1 items-end mt-6">
            <input @if ($errors->has('heels.' . $index)) class="border-[#D32F2F]" @endif class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm' wire:key="{{$index}}" type="text" wire:model="heels.{{ $index }}" placeholder="{{$index +1 }}. Novi tip pete" /></input><button type="button" wire:key="{{ $index }}" wire:click="removeHeelInput({{$index}})"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                </svg></button>
        </div>
        @error('heels.' . $index)
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-2 lg:w-52">{{ $message }}</span>
        @enderror
        @endforeach
        <div class="flex items-center justify-end mt-4 gap-4">
            <!-- Button to add another input field for a new material -->
            <button class="mt-2" type="button" wire:click="addHeelInput"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg></button>
            <x-primary-button wire:click="insertHeel" class="mt-2">
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
            <x-primary-button wire:click="resetHeel" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            <!-- Failed insert message -->
            @elseif(session('errorException'))
            <div class="my-4" x-data="{open:true}">
                <div class="text-[#721c24] rounded-md w-60 bg-[#f8d7da] p-2.5" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
            </div>
            <!-- Resetting input -->
            <x-primary-button wire:click="resetHeel" class="mt-2">
                {{ __('Očisti') }}
            </x-primary-button>
            @endif
            @isset($heelsAll)
            <h3 class="mt-6">Trenutno dostupne vrste peti:</h3>
            <!-- Showing heel categories -->
            <div class="mt-6 grid grid-cols-4 gap-3 gap-x-0 justify-items-center">
                @foreach ($heelsAll as $name)
                @if($name->source=="user")
                <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->heel_type, $heels)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->heel_type}}</p><button type="button" wire:click="deleteHeelCategory({{$name->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                    </svg></button>
                    @elseif($name->source=="default")
                    <p class="p-1 min-w-16 max-w-[6rem] break-words self-center @if(in_array($name->heel_type, $heels)) bg-sky-200 @endif border border-gray-200 rounded-lg shadow">{{$name->heel_type}}</p>
                    @endif
                @endforeach
                @endisset
            </div>
        </div>
    </div>