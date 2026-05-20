<div>
    <!--Livewire frontend component - view with input fields for updating product stock for different colors and sizes-->
    <div class="flex flex-col overflow-auto items-center bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 p-4">
        <p class="text-xl mb-6 mt-6">{{$product->product_name}}</p>
        <hr class="w-[35%] h-[15px] mb-6">
        </hr>
        <div class="flex flex-row overflow-scroll">
            @foreach($images as $images)
            <img src="{{asset('storage/'.$images->image_320x320)}}" width=320 alt="product image">
            @endforeach
        </div>
        <div class="mt-6 w-[100%] sm:w-fit sm:grid sm:grid-cols-3 gap-[3rem] items-center justify-items-center border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            @foreach($variantStocks as $key=> $items)
            <div class="flex flex-col items-center gap-3">
                <p class="text-xl">Size: {{$size[$key]->size}}</p>
                <hr>
                </hr>

                <p>Boja: {{$color[$key]->color}}</p><input type="color" value="{{$color[$key]->hex_code}}" disabled></input>
                <p>Trenutna količina:</p>
                <div @if ($errors->has('productStocks.' . $key)) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                    <input @if(($variantStocks[$key]->stock_quantity)<=\App\Livewire\AddProductStock::minQuantity && $this->toggle==false)class="bg-[#f8d7da] text-[#721c24]" @endif wire:key="{{ $key }}" wire:model="productStocks.{{$key}}" id="productStock" type="number" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="{{$variantStocks[$key]->stock_quantity}}">
                </div>
                @error('productStocks.' . $key)
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1 w-[80%]">{{ $message }}</span>
                @enderror
            </div>

            @endforeach

            @if(session('errorException'))
            <span class="error text-[#D32F2F] mt-1 w-[80%]">{{session('errorException')}}</span>
            @endif

        </div>
        <!-- Setting up the minimum quantity below which the app notify the admin-->
        <div class="p-6 border mt-4 border-gray-200 flex flex-col items-center gap-[1rem]">
            <p class="p-6  text-gray-700">Odredite donji prag za broj artikala ovog proizvoda ispod kojeg će vas aplikacija vizuelno obavijestiti:</p>
            <input type="number" wire:model="bottomStocksLimit" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="5"></input>
        </div>

        <section class="mt-10 flex flex-col-reverse sm:flex-row gap-4" x-data="{open:true}">
            <!-- Back button with backend method to transfer correct url parameter to last page (backToProduct) -->
            <a wire:click="backToProduct" class="col-start-1 min-w-[206.15px] cursor-pointer lg:col-span-2 lg2:col-start-1 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:navigate>Natrag</a>

            <x-primary-button wire:click="updateStock" wire:offline.attr="disabled" @click="open = ! open" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="justify-center col-start-2 lg2:col-start-4">

                {{ __('Ažuriraj') }}

            </x-primary-button>

            @if (session('status'))
            <!-- Successful insert message -->
            <div class="lg:col-span-2 lg2:col-span-1 lg2:col-start-4 lg:col-start-3 row-start-3">
                <div class="text-[#004085]  rounded-md p-[0.3rem] bg-[#cce5ff] justify-center" x-show="!open" x-on:click.outside="open=true" x-transition>{{session('status')}}</div>
            </div>
            @endif

    </div>
    </section>
</div>