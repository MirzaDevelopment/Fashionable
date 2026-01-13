<div class="flex flex-col items-center"  x-data="{ open: false }"> <!--Frontend component for rendering present material categories for chosen product-->
    <!-- Button to toggle categories -->
    <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 p-2 text-gray-900 mb-6" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-900 text-white' : ''" @click="red = ! red">
        Materijal proizvoda
    </button>
    <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4" x-show="open" x-transition>
        <!-- Category representation icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="m16,20.063c-1.096.521-2.366.937-4,.937s-2.904-.416-4-.937v-2.398c1.26.721,2.364,1.335,4,1.335s2.74-.614,4-1.335v2.398Zm5-4.063v2h3v-2h-3ZM3,4H0v2h3v-2Zm9,3c-1.636,0-2.74-.614-4-1.335v2.398c1.096.521,2.366.937,4,.937s2.904-.416,4-.937v-2.398c-1.26.721-2.364,1.335-4,1.335Zm9-3v2h3v-2h-3ZM3,16H0v2h3v-2Zm6.5-3.549c-.529-.234-1.037-.52-1.574-.828-1.329-.761-2.836-1.623-4.926-1.623H0v2h3c1.292,0,2.239.541,3.436,1.227.898.514,1.871,1.069,3.064,1.419v-2.194Zm11.5-2.451c-2.09,0-3.597.862-4.926,1.623-.537.308-1.045.594-1.574.828v2.194c1.193-.35,2.166-.905,3.064-1.419,1.197-.686,2.144-1.227,3.436-1.227h3v-2h-3Zm-10,11.939v2.061h2v-2.061c-.32.035-.649.061-1,.061s-.68-.026-1-.061Zm1-11.939c-.351,0-.68-.026-1-.061v7.936c.313.072.637.126,1,.126s.687-.054,1-.126v-7.936c-.32.035-.649.061-1,.061ZM11,0v5.874c.313.072.637.126,1,.126s.687-.054,1-.126V0h-2Zm-5,0h-2v9.066c.735.089,1.393.274,2,.5V0Zm0,14.128c-.019-.011-.042-.022-.061-.033-.752-.43-1.338-.749-1.939-.93v10.835h2v-9.872Zm12,0v9.872h2v-10.835c-.602.181-1.188.5-1.939.93-.019.011-.042.023-.061.034Zm0-14.128v9.566c.607-.226,1.265-.411,2-.5V0h-2Z" />
        </svg>
        @isset($materialsAll)

        <h3 class="mt-6">Promjeni materijal proizvoda:</h3>
        <!-- Showing material categories -->
        <div class="mt-6 grid grid-cols-2 gap-2 gap-x-10 justify-items-center">
            @foreach ($materialsAll as $index => $name)
            @if((in_array($name->material, $materialNames)))
            <p wire:click="$parent.MaterialDeSelect('{{$name->material}}')" class="{{in_array($name->material, $materialDeSelect)? 'p-1 min-w-16  self-center bg-white  border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-[#EDE8D0] border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->material}}</p>
            @else
            <p wire:click="$parent.MaterialSelect('{{$name->material}}')" class="{{in_array($name->material, $materialSelect)? 'p-1 min-w-16  self-center bg-[#EDE8D0]  border border-gray-200 rounded-lg shadow' : 'p-1 min-w-16  self-center bg-white border border-gray-200 rounded-lg shadow'}}" style="cursor: pointer" wire:key="{{$name->id}}">{{$name->material}}</p>
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
        @elseif(session('errorMaterials'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorMaterials')}}</div>
        </div>
        @elseif(session('emptyMaterials'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('emptyMaterials')}}</div>
        </div>
        @endif
    </section>
        <div class="mt-6">
    <x-primary-button wire:click="$parent.editMaterials" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

        {{ __('Ažuriraj') }}

    </x-primary-button>
    
    </div>
    </div>
</div>