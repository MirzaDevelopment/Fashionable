<div><!--Livewire frontend component for showing and filtering products on commerce page-->
    <section class="mt-[4rem] mb-[4rem] 2xl:h-[68px] m-[1rem] flex flex-col flex-col-reverse 2xl:grid 2xl:grid-rows-1 2xl:grid-cols-4 gap-[4rem] 2xl:justify-between items-center relative">
        <div class="relative 2xl:self-baseline 2xl:min-w-[400px] h-[68px] 2xl:max-w-[400px] h-auto flex justify-center 2xl:justify-normal 2xl:items-center" id="explore">
            <aside class="flex flex-col top-0  absolute  lg:min-w-[400px] lg:max-w-[400px]" x-data="{ open: false, red: false }">
                <!--Frontend livewire components that render category filters-->
                <button class="w-[15rem] lg:w-[400px] min-h-[40px] lg:min-h-[56px]  lg:h-[auto] lg:p-[1rem] text-base lg:text-2xl 2xl:max-w-[90%] text-gray-800" :class="red ? 'text-gray-900 border-b border-gray-900 bg-gray-50' : 'border-b border-gray-200  bg-white'" @click="red = !red; open = !open">Kategorije proizvoda</button>
                <section class="overflow-scroll 2xl:overflow-auto max-h-[300px] 2xl:max-h-fit" x-show="open" x-transition>
                    <div class="flex flex-col items-center p-[1px]" x-data="{ openType: false, red: false }">
                        <button class="w-[80%] h-[35px] lg:h-[auto] text-base lg:text-2xl lg:p-[1rem] text-gray-800" :class="red ? 'text-gray-900 border-b border-gray-900 bg-gray-50' : 'border-b border-gray-200 bg-white'" @click="red = !red; openType = !openType">Vrste</button>
                        <div x-show="openType" x-transition>
                            <!--Product type categories-->
                            <livewire:type-category-front :typeSelect="$typeSelect" :selectedTypesContainer="$selectedTypesContainer" />
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-[1px]" x-data="{ openGender: false, red: false }">
                        <button class="w-[80%] h-[35px] lg:h-[auto]  text-base lg:text-2xl  lg:p-[1rem] text-gray-800" :class="red ? 'text-gray-900 border-b border-gray-900 bg-gray-50 z-[5]' : 'border-b border-gray-200 bg-white z-[5]'" @click="red = !red; openGender = !openGender">Spol</button>
                        <div x-show="openGender" x-transition>
                            <!--Product gender categories-->
                            <livewire:gender-category-front :genderSelect="$genderSelect" />
                        </div>
                    </div>
                    <div class="flex flex-col items-center p-[1px] relative z-[5]" x-data="{ openTag: false, red: false }">
                        <button class="w-[80%]  h-[35px] lg:h-[auto] text-base lg:text-2xl  lg:p-[1rem] text-gray-800" :class="red ? 'text-gray-900 border-b border-gray-900 bg-gray-50 z-[5]' : 'border-b border-gray-200 bg-white z-[5]'" @click="red = !red; openTag = !openTag"> Oznake</button>
                        <div x-show="openTag" x-transition>
                            <!--Product tag categories-->
                            <livewire:tag-category-front :tagSelect="$tagSelect" />
                        </div>
                    </div>
                    <div class="flex justify-evenly">
                        <button wire:click="clearAll" class="bg-white z-[5] text-gray-700 border border-[#cccccc] text-base px-3 py-1.5 rounded flex items-center gap-1 hover:bg-[#fbeaea] hover:text-red-700 transition-colors duration-150 lg:h-[auto] lg:text-xl lg:p-[1rem]">
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
            <!--Product search-->
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
            <span class="text-base lg:text-2xl mr-[1rem]"> Poredaj: </span>
            <img class="lg:w-[60px]" style="cursor: pointer" wire:click="sortProduct('product_name')" src="http://melisa.test/storage/images/sortIcon.svg" alt="sort_by_name" width="40" height="40">
            <img class="lg:w-[60px]" style="cursor: pointer" wire:click="sortProduct('price')" src="http://melisa.test/storage/images/sortIconPrice.svg" alt="sort_by_price_icon" width="40" height="40">
        </div>
    </section>
    <hr class="border-t-1 row-start-1 col-span-2 2xl:mt-8 border-gray-800 max-w-[5%] lg:mt-[6.5rem] m-auto mb-[4rem] lg:mb-[2rem] col-span-1">
    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
    @if ($page == $products->lastPage())
    <!--Rendering all products from database-->
    <section class="grid grid-rows-1 grid-cols-1 gap-y-[0.5rem] sm:grid-cols-2 xl:grid-cols-3 bg-slate-100  justify-items-center items-center mt-[1rem] p-[0.5rem] mb-[3rem]">
        @isset($products)
        @foreach ($products as $product)
        <div class="flex flex-col cursor-pointer relative place-content-evenly hover:shadow-lg shadow-black/10 transition-all duration-300 ease-out  items-center min-w-[100%] min-h-[100%] gap-[1rem] xl:gap-[2rem] max-w-xs overflow-hidden bg-white p-[1rem]">
            <div class="">
                <p class="text-base text-gray-800 font-bold w-fit">Dostupno u:</p>
                <span class="flex flex-row flex-wrap text-sm mb-[1rem] text-gray-800 items-center">
                    @foreach ($product->colors as $index => $colors)
                    <div class="mr-[0.5rem] text-sm" wire:key="{{$index}}">{{$colors->color}}</div>
                    @endforeach

                </span>
                <!--Wishlist button-->
                <div class="transition-all duration-300 group relative flex">
                    @if(!in_array($product->id, $wishListArray))
                    <button aria-label="Name" wire:key="{{$index}}" wire:click="wishListItem({{$product->id}})"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3 c1.74 0 3.41 0.81 4.5 2.09 C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg></button>
                    @else
                    <button aria-label="Name" wire:key="{{$index}}" wire:click="wishListItem({{$product->id}})"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="black">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
           2 5.42 4.42 3 7.5 3 
           c1.74 0 3.41 0.81 4.5 2.09 
           C13.09 3.81 14.76 3 16.5 3 
           19.58 3 22 5.42 22 8.5 
           c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg></button>
                    @endif
                    <p class="text-base ml-[0.2rem] self-end group-hover:opacity-100 transition-opacity duration-300 opacity-0">Dodaj na listu želja!</p>
                    @cannot('create', App\Models\Wishlist::class)
                    @if (!empty($authErrorMessage[$product->id]))
                    <div class="mt-3 rounded-lg w-[200px] right-[25px] absolute border border-gray-200 bg-white p-3">
                        <p class="text-sm text-gray-700">
                            Za korištenje liste želja potrebno je da se
                            <a href="/register" class="font-large text-black underline hover:opacity-70">
                                registrujete
                            </a>
                            tako da možete putem emaila da primite obavijesti o sniženjima.
                        </p>
                    </div>
                    @endif
                    @endcan

                </div>
                <hr class="border-t-1 border-gray-800 mb-[10%] w-[50%]">
                </hr>
                <!-- Successful insert message -->
                @if (!empty($wishListSuccess[$product->id]))
                <div x-data="{ open: true }" x-show="open" x-transition x-on:click.outside="open = false" class="mt-3 rounded-md bg-[#cce5ff] text-[#004085] p-2.5">
                    {{ $wishListSuccess[$product->id] }}
                </div>
                @endif
                @if (!empty($wishListFailed[$product->id]))
                <div x-data="{ open: true }" x-show="open" x-transition x-on:click.outside="open = false" class="mt-3 rounded-md bg-[#f8d7da] text-[#721c24] p-2.5">
                    {{ $wishListFailed[$product->id] }}
                </div>
                @endif
                <!--Images-->
                @foreach ($product->images as $images)
                <picture>
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/'.$images->image_320x320) }}">
                    <source media="(max-width: 640px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
                    <source media="(max-width: 1023px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
                    <source media="(min-width: 1024px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
                    <img class="object-cover transition-transform duration-500 ease-out hover:scale-105" loading="lazy" fetchpriority="low" decoding="async" src="{{ asset('storage/'.$images->image_400x400)}}" width="400" height="600" alt="product image">
                </picture>
                @break
                @endforeach
            </div>
            <hr class="border-t-1 row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
            <h3 class="text-xl lg:text-3xl 2xl:text-4xl font-semibold text-gray-900">{{ $product->product_name }}</h3>
            <span class="text-sm text-gray-800  lg:text-2xl lg2:text-3xl">
                @foreach ($product->materials as $key=> $materials)
                @if($key==0)
                <span class="bg-slate-200 p-2">{{$materials->material}}</span>
                @elseif($key>0)
                <span class="ml-[-4px]">,</span> <span class="bg-slate-200 p-2">{{$materials->material}}</span>
                @else
                <span class="bg-slate-200 p-2">{{$materials->material}}</span>
                @endif
                @endforeach
                @php
                $uniqueSizes=collect($product->sizesVariant)->unique('size')
                @endphp
                @foreach($uniqueSizes as $sizes)
                <span class="bg-slate-200 p-2">{{$sizes->size}}</span>
                @endforeach
            </span>
            @if(isset($product->discount) && !empty($product->discount) && $currentDate->gte($product->start_date) && $currentDate->lte($product->end_date))
            <span class="text-sm lg:text-2xl lg2:text-3xl text-[#9E1B32] bg-white border border-[#9E1B32] font-semibold px-2.5 py-1 rounded-md shadow-md absolute left-3"> Trenutni popust: - {{$product->discount}} %</span>
            <span class="text-sm lg:text-2xl lg2:text-3xl  border border-amber-300 text-amber-700 
            medium px-3 py-1 rounded-full bg-amber-50 ">Cijena: {{number_format ($product->price-($product->price*($product->discount/100)), 2,'.',' ')}} $</span>
            <p class="line-through text-sm lg:text-xl 2xl:text-2xl">Stara cijena: {{number_format($product->price, 2, '.', ' ')}} $</p>
            @else
            <span class="text-sm lg:text-2xl lg2:text-3xl text-gray-800 font-bold ">Cijena: {{$product->price}} $</span>
            @endif

            <hr class="border-t-1 row-start-1 col-span-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[25%] col-span-1">
            </hr>
            <!--Buy button-->
          <button type="button" wire:click="buyProduct" class="text-white bg-gray-800 active:bg-gray-900 hover:bg-gray-700 
           font-semibold tracking-wide text-base 
           p-2.5 w-[25%] 
           rounded-lg 
           transition-all duration-200 ease-in-out
           shadow-md hover:shadow-lg
           focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
           cursor-pointer">
                Kupi
            </button>
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