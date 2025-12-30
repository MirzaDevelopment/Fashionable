<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for rendering all types in database -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-900 text-white' : ''" @click="red = ! red">
        Product type 
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" width="100" height="100" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="M23.5,0c-.276,0-.5,.224-.5,.5v1.5h-7.5c-.827,0-1.5,.673-1.5,1.5v3.5h-4V3.5c0-.276,.224-.5,.5-.5h1c.276,0,.5-.224,.5-.5s-.224-.5-.5-.5h-1c-.827,0-1.5,.673-1.5,1.5v3.5h-1.755c-2.579,0-4.245,1.492-4.245,3.8v.7c0,.827,.673,1.5,1.5,1.5h.5v4.5c0,1.378,1.122,2.5,2.5,2.5h9c1.378,0,2.5-1.122,2.5-2.5v-4.5h.5c.827,0,1.5-.673,1.5-1.5v-.7c0-2.308-1.667-3.8-4.245-3.8h-1.755V3.5c0-.276,.224-.5,.5-.5h7.5V23.5c0,.276,.224,.5,.5,.5s.5-.224,.5-.5V.5c0-.276-.224-.5-.5-.5ZM8.477,8.916c-.508-.14-.942-.466-1.202-.916h1.928c-.299,.259-.534,.571-.726,.916Zm7.744-.916c-.349,.606-.993,1-1.721,1s-1.372-.394-1.721-1h3.442ZM6,17.5v-5c0-.276-.224-.5-.5-.5h-1c-.276,0-.5-.224-.5-.5v-.7c0-1.827,1.227-2.467,2.221-2.687,.334,.835,1.032,1.477,1.891,1.746-.067,.297-.112,.608-.112,.941v.7c0,.827,.673,1.5,1.5,1.5h.5v4.5c0,.565,.195,1.081,.513,1.5h-3.013c-.827,0-1.5-.673-1.5-1.5Zm14-6.7v.7c0,.276-.224,.5-.5,.5h-1c-.276,0-.5,.224-.5,.5v5c0,.827-.673,1.5-1.5,1.5h-4c-.827,0-1.5-.673-1.5-1.5v-5c0-.276-.224-.5-.5-.5h-1c-.276,0-.5-.224-.5-.5v-.7c0-2.137,1.679-2.652,2.699-2.768,.428,1.172,1.529,1.968,2.801,1.968s2.373-.796,2.801-1.968c1.02,.116,2.699,.631,2.699,2.768ZM.996,3V23.5c0,.276-.224,.5-.5,.5S-.004,23.776-.004,23.5V.5C-.004,.224,.22,0,.496,0S.996,.224,.996,.5v1.5H6.5c.276,0,.5,.224,.5,.5s-.224,.5-.5,.5H.996Z" />
        </svg>
            @isset($typesAll)
            <h3 class="mt-6">Product types currently in database:</h3>
            <!-- Showing size categories -->
            <div class="mt-6 grid grid-cols-2 gap-2 gap-x-10 justify-items-center">
                @foreach ($typesAll as $name)
                <p wire:click="$parent.TypeSelect('{{$name->type_name}}')" class="{{in_array($name->type_name, $typeSelect)? 'p-1 min-w-16  self-center bg-[#EDE8D0] border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-white border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->type_name}}</p>
                @endforeach
                @endisset
            </div>
        </div>
    </div>
    