<div><!--Livewire frontend component for showing and filtering products on commerce page-->
    <section class="mt-[4rem] mb-[4rem] 2xl:h-[68px] m-[1rem] flex flex-col flex-col-reverse 2xl:grid 2xl:grid-rows-1 2xl:grid-cols-4 gap-[4rem] 2xl:justify-between items-center relative">
        <div class="relative 2xl:self-baseline 2xl:min-w-[400px] h-[68px] 2xl:max-w-[400px] h-auto flex justify-center 2xl:justify-normal 2xl:items-center" id="explore">
            <aside class="flex flex-col top-0  absolute  lg:min-w-[400px] lg:max-w-[400px]" x-data="{ open: false, red: false }">
                <!--Frontend livewire components that render category filters-->
                <button class="w-[15rem] lg:w-[400px] h-[35px] lg:h-[auto] lg:p-[1rem] lg:text-[calc(0.8rem+1vw)] xl:text-[1.5rem] 2xl:max-w-[90%] text-white" :class="red ? 'bg-gray-400' : 'bg-gray-900'" @click="red = !red; open = !open">Kategorije proizvoda</button>
                <section class="overflow-scroll 2xl:overflow-auto max-h-[300px] 2xl:max-h-fit" x-show="open" x-transition>
                    <div class="flex flex-col items-center p-[1px]" x-data="{ openType: false, red: false }">
                        <button class="w-[80%] h-[35px] lg:h-[auto] lg:text-[calc(0.8rem+1vw)] xl:text-[1.5rem] lg:p-[1rem] text-white" :class="red ? 'bg-gray-400' : 'bg-gray-900'" @click="red = !red; openType = !openType">Vrste</button>
                        <div x-show="openType" x-transition>
                            <!--Product type categories-->
                            <livewire:type-category-front :typeSelect="$typeSelect" :selectedTypesContainer="$selectedTypesContainer" />
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-[1px]" x-data="{ openGender: false, red: false }">
                        <button class="w-[80%] h-[35px] lg:h-[auto] text-white lg:text-[calc(0.8rem+1vw)] xl:text-[1.5rem]  lg:p-[1rem]" :class="red ? 'bg-gray-400 z-[5]' : 'bg-gray-900 z-[5]'" @click="red = !red; openGender = !openGender">Spol</button>
                        <div x-show="openGender" x-transition>
                            <!--Product gender categories-->
                            <livewire:gender-category-front :genderSelect="$genderSelect" />
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-[1px] relative z-[5]" x-data="{ openTag: false, red: false }">
                        <button class="w-[80%] h-[35px] lg:h-[auto] text-white lg:text-[calc(0.8rem+1vw)] xl:text-[1.5rem]  lg:p-[1rem]" :class="red ? 'bg-gray-400 z-[5]' : 'bg-gray-900 z-[5]'" @click="red = !red; openTag = !openTag"> Oznake</button>
                        <div x-show="openTag" x-transition>
                            <!--Product tag categories-->
                            <livewire:tag-category-front :tagSelect="$tagSelect" />
                        </div>
                    </div>
                    <div class="flex justify-evenly">
                        <button wire:click="clearAll" class="bg-white z-[5] text-gray-700 border border-[#cccccc] text-sm px-3 py-1.5 rounded flex items-center gap-1 hover:bg-[#fbeaea] hover:text-red-700 transition-colors duration-150 lg:h-[auto] lg:text-[calc(0.8rem+1vw)] xl:text-[1.5rem] lg:p-[1rem]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-8 lg:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Očisti sve
                        </button>
                    </div>
                </section>
            </aside>

        </div>
        <div class="relative 2xl:col-span-2">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 lg:w-5 lg:h-5  text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <x-search-input />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!--Sorting products from database-->
        <div class="relative flex items-center 2xl:justify-end">
            <span class="text-lg lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem] mr-[1rem]"> Sort by: </span>
            <img class="lg:w-[60px]" style="cursor: pointer" wire:click="sortProduct('product_name')" src="http://melisa.test/storage/images/sortIcon.svg" alt="sort_by_name" width="40" height="40">
            <img class="lg:w-[60px]" style="cursor: pointer" wire:click="sortProduct('price')" src="http://melisa.test/storage/images/sortIconPrice.svg" alt="sort_by_price_icon" width="40" height="40">
        </div>
    </section>
    <hr class="border-t-1 row-start-1 col-span-2 2xl:mt-8 border-gray-800 max-w-[5%] lg:mt-[6.5rem] m-auto mb-[4rem] lg:mb-[2rem] col-span-1">
    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
    @if ($page == $products->lastPage())
    <section class="grid grid-rows-1 grid-cols-1 gap-y-[0.5rem] sm:grid-cols-2 xl:grid-cols-3 bg-gray-100  justify-items-center items-center mt-[1rem] p-[0.5rem] mb-[3rem]">
        <!--Rendering all products from database-->
        @isset($products)
        @foreach ($products as $product)
        <div class="flex flex-col cursor-pointer place-content-evenly hover:-translate-y-1 hover:shadow-lg shadow-black/10 transition-all duration-300 ease-out  items-center min-w-[100%] min-h-[100%] gap-2 max-w-xs  overflow-hidden bg-white p-[1rem]">
            <div class="">
                <span class="flex flex-row text-[1.2rem] mb-[1rem] text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">
                    @foreach ($product->colors as $index => $colors)
                    <div class="m-1 border-2 shadow-md" wire:key="{{$index}}" style="width: 25px; height: 25px; background-color: {{$colors->hex_code}};
            border-radius: 50%;">
                    </div>
                    @endforeach
                </span>
                @foreach ($product->images as $images) <img class="object-cover" loading="lazy" src="{{asset('storage/'.$images->image_400x400)}}" width="400" height="auto" alt="product image">
                @break
                @endforeach
            </div>
            <hr class="border-t-1 row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
            <h3 class="text-[1.8rem] lg:text-[2.2rem] 2xl:text-[3rem] font-semibold text-gray-800">{{ $product->product_name }}</h3>
            <span class="text-[1.2rem] text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">
                @foreach ($product->materials as $key=> $materials)
                @if($key==0)
                {{ $materials->material}}
                @elseif($key>0)
                <span class="ml-[-4px]">,</span> {{$materials->material}}
                @else
                {{ $materials->material}}
                @endif
                @endforeach
            </span>
            <span class="text-gray-900 text-[1.2rem] font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">Veličine:
                @php
                $uniqueSizes=collect($product->sizesVariant)->unique('size')
                @endphp
                @foreach($uniqueSizes as $sizes)
                {{$sizes->size}}
                @endforeach
            </span>
            @if(isset($product->discount) && !empty($product->discount) && $currentDate->lte($product->end_date))
            <span class="text-[1.2rem] lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem] text-[#9E1B32]"> Trenutni popust: - {{$product->discount}} %</span>
            <span class="text-[1.2rem] lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem] font-bold text-gray-900">Cijena: {{number_format ($product->price-($product->price*($product->discount/100)), 2,'.',' ')}} $</span>
            <p class="line-through lg:text-xl 2xl:text-[1.8rem]">Stara cijena: {{number_format($product->price, 2, '.', ' ')}} $</p>
            @else
            <span class="text-[1.2rem] text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">Cijena: {{$product->price}} $</span>
            @endif

            <hr class="border-t-1 row-start-1 col-span-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[25%] col-span-1">
            </hr>
        </div>
        @endforeach
        @endisset
    </section>
    <!--Rendering message if no products are found-->
    <div>
        @if(count($products)==0)
        <p class="text-xl lg:text-2xl text-[#D32F2F]">{{$empty}}</p>
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif
    </div>
    @endif
    @endforeach
    <div id="frontPagination" class="mr-[2rem] ml-[2rem] mb-[3rem]">
        {{ $products->links(data: ['scrollTo' => '#explore'])  }}
    </div>
</div>