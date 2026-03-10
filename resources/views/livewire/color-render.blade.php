<div class="flex flex-col items-center " x-data="{ open: false }"><!-- Livewire frontend component for rendering all colors in database -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Boje
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="100" height="100">
            <path d="M21,4v-1.5c0-1.379-1.122-2.5-2.5-2.5H2.5C1.122,0,0,1.121,0,2.5V6.5c0,1.379,1.122,2.5,2.5,2.5H18.5c1.378,0,2.5-1.121,2.5-2.5v-1.5c1.103,0,2,.897,2,2v2c0,1.103-.897,2-2,2h-7.5c-1.93,0-3.5,1.57-3.5,3.5v.55c-1.14,.232-2,1.242-2,2.45v4c0,1.379,1.122,2.5,2.5,2.5s2.5-1.121,2.5-2.5v-4c0-1.208-.86-2.217-2-2.45v-.55c0-1.379,1.122-2.5,2.5-2.5h7.5c1.654,0,3-1.346,3-3v-2c0-1.654-1.346-3-3-3Zm-1,2.5c0,.827-.673,1.5-1.5,1.5H2.5c-.827,0-1.5-.673-1.5-1.5V2.5c0-.827,.673-1.5,1.5-1.5H18.5c.827,0,1.5,.673,1.5,1.5V6.5Zm-8,11v4c0,.827-.673,1.5-1.5,1.5s-1.5-.673-1.5-1.5v-4c0-.827,.673-1.5,1.5-1.5s1.5,.673,1.5,1.5Z" />
        </svg>
            @isset($colorsAll)
            <h3 class="mt-6">Dostupne boje:</h3>
            <!-- Showing color categories -->
            <div class="mt-6 grid grid grid-cols-2 gap-2 gap-x-10  items-center justify-items-center">
                @foreach ($colorsAll as $name)
                <input type="color" value="{{$name->hex_code}}" disabled></input>
                <p wire:click="$parent.ColorSelect('{{$name->color}}')" class="{{in_array($name->color, $colorSelect)? 'p-1 min-w-16  self-center bg-[#EDE8D0] border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-white border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->color}}</p>
                @endforeach
                @endisset
            </div>
        </div>

    </div>