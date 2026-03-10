<div class="flex flex-col items-center"  x-data="{ open: false }"> <!--Frontend component for rendering present size categories for chosen product-->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-800 text-white' : ''" @click="red = ! red">
        Veličine prozivoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" width=100 height=100 data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m9.5,9c2.236,0,4.5-.687,4.5-2,0-2.627-9-2.627-9,0,0,1.313,2.264,2,4.5,2Zm0-3c2.273,0,3.5.71,3.5,1s-1.227,1-3.5,1-3.5-.71-3.5-1,1.227-1,3.5-1Zm11,6h-1.5v-5c0-3.309-4.262-6-9.5-6C4.672,1,.683,3.288.086,6.236c-.05.078-.086.165-.086.264v11.286c0,2.924,3.901,5.214,8.881,5.214h11.619c1.93,0,3.5-1.57,3.5-3.5v-4c0-1.93-1.57-3.5-3.5-3.5Zm-2.5,0h-3.26c1.387-.582,2.513-1.389,3.26-2.336v2.336ZM9.5,2c4.687,0,8.5,2.243,8.5,5s-3.813,5-8.5,5S1,9.757,1,7,4.813,2,9.5,2Zm13.5,17.5c0,1.379-1.121,2.5-2.5,2.5h-.5v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-3v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-3v-4.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.5h-2.119c-.298,0-.591-.011-.881-.03v-4.47c0-.276-.224-.5-.5-.5s-.5.224-.5.5v4.368c-3.398-.465-6-2.143-6-4.082v-8.123c1.557,1.974,4.777,3.336,8.5,3.336h11c1.379,0,2.5,1.121,2.5,2.5v4Z" />
        </svg>
        @isset($sizesAll)

        <h3 class="mt-6">Promijeni veličine proizvoda:</h3>
        <!-- Showing size categories -->
        <div class="mt-6 grid grid-cols-2 gap-2 gap-x-10 justify-items-center">
            @foreach ($sizesAll as $index => $name)
            @if((in_array($name->size, $sizeNames)))
            <p wire:click="$parent.SizeDeSelect('{{$name->size}}')" class="{{in_array($name->size, $sizeDeSelect)? 'p-1 min-w-16  self-center bg-white  border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-[#EDE8D0] border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->size}}</p>
            @else
            <p wire:click="$parent.SizeSelect('{{$name->size}}')" class="{{in_array($name->size, $sizeSelect)? 'p-1 min-w-16  self-center bg-[#EDE8D0]  border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-white border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->size}}</p>
            @endif
            @endforeach
            @endisset

        </div>
        <section class="mt-6">
        @if (session('status'))
        <!-- Successful insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
        </div>
        @elseif(session('errorException'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
        </div>
        @elseif(session('errorSizes'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorSizes')}}</div>
        </div>
        @elseif(session('emptySizes'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('emptySizes')}}</div>
        </div>
        @endif
    </section>
        <div class="mt-6">
    <x-primary-button wire:click="$parent.editSizes" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

        {{ __('Ažuriraj') }}

    </x-primary-button>
    </div>
    </div>
</div>