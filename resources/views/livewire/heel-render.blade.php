<div class="flex flex-col items-center" x-data="{ open: false }"><!-- Livewire frontend component for rendering all heels in database -->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Vrste štikli
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m20.776,16.213l-6.897-3.135c-.534-.243-.879-.778-.879-1.365V3.501c0-1.053-.467-2.039-1.281-2.707-.814-.668-1.872-.931-2.906-.726L2.813,1.269c-1.63.326-2.813,1.769-2.813,3.432v17.299c0,1.103.897,2,2,2h4c1.103,0,2-.897,2-2v-1.705c.279.122.543.28.783.472l2.809,2.247c.795.636,1.793.986,2.812.986h6.816c1.533,0,2.78-1.247,2.78-2.78,0-2.152-1.266-4.117-3.224-5.007Zm-13.776,5.787c0,.551-.449,1-1,1H2c-.551,0-1-.449-1-1v-2h5.597c.135,0,.27.009.403.024v1.976Zm14.22,1h-6.816c-.792,0-1.568-.272-2.187-.767l-2.809-2.247c-.795-.636-1.793-.986-2.812-.986H1V4.701c0-1.188.845-2.219,2.01-2.452l2.99-.598v9.849c0,.276.224.5.5.5s.5-.224.5-.5V1.5c0-.016,0-.032-.002-.048l2.012-.403c.737-.146,1.493.041,2.075.519.582.477.915,1.181.915,1.933v8.211c0,.978.575,1.871,1.465,2.275l6.896,3.135c1.603.728,2.638,2.336,2.638,4.097,0,.981-.799,1.78-1.78,1.78Z" />
        </svg>
            @isset($heelsAll)
            <h3 class="mt-6">Trenutno dostupne vrste štikli:</h3>
            <!-- Showing heel categories -->
            <div class="mt-6 grid grid-cols-2 gap-2 gap-x-8 justify-items-center">
                @foreach ($heelsAll as $name)
                <p wire:click="$parent.HeelSelect('{{$name->heel_type}}')" class="{{in_array($name->heel_type, $heelSelect)? 'p-1 min-w-16  self-center bg-[#EDE8D0] border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-white border border-gray-200 rounded-lg shadow'}}"style="cursor: pointer" wire:key="{{$name->id}}">{{$name->heel_type}}</p>
                @endforeach
                @endisset
            </div>
        </div>
    </div>