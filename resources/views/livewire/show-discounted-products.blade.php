<div id="special-prices" class="p-[0.5rem] bg-slate-100  mt-[3rem] z-[10]"><!--Livewire frontend component for showing discounted products on commerce page-->
  <div class="bg-gray-800 text-white py-6 px-8 rounded-lg shadow-lg max-w-6xl mx-auto">
    <h2 class="text-4xl lg:text-5xl font-extrabold text-center mb-4">Akcijske cijene</h2>
    <p class="text-center text-xl max-w-lg lg:text-2xl mx-auto mb-6">
      Uživajte u ekskluzivnim ponudama na najbolje ocijenjenim proizvodima. Požurite, ponude su vremenski ograničene!
    </p>
  </div>
  <section class="grid grid-rows-1  relative bg-slate-100 relative justify-center items-center">
    <button class="nav-btn nav-left absolute lg:text-3xl bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white">&#10094;</button>
    <div class="flex lg:mt-8 items-center w-[100%] md:w-[99%] lg:w-[100%] scroll-smooth snap-x snap-mandatory transition-transform m-auto duration-300 ease-in-out gap-[25px] py-5 overflow-y-auto  [scrollbar-width:none] [-ms-overflow-style:none]" id="carouselTrackDiscounted">
      @if($discountedProducts->isNotEmpty())
      @foreach ($discountedProducts as $index=> $product)
      <div id="discountedItem" class="lg:flex gap-[1rem] flex flex-col xl:flex-row place-content-evenly items-center min-w-[100%] snap-start rounded-xl overflow-hidden bg-white shadow-md  p-[1rem] rounded-lg  transform transition duration-300">
        @foreach ($product->images as $images)
        <picture>
          <source media="(max-width: 320px)" srcset="{{ asset('storage/'.$images->image_200x200) }}">
          <source media="(max-width: 640px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
          <source media="(max-width: 1023px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
          <source media="(max-width: 1279px)" srcset="{{ asset('storage/'.$images->image_800x800) }}">

          <!-- 2XL screens: 1536px+ -->
          <source media="(min-width: 1536px)" srcset="{{ asset('storage/'.$images->image_800x800) }}">

          <!-- XL–2XL fallback (1280px–1535px) -->
          <source media="(min-width: 1280px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">

          <img class="w-fit lg:h-[700px] xl:ml-[5rem] object-contain" loading="lazy" src="{{ asset('storage/'.$images->image_400x400) }}" width="400" height="600" alt="product_image">
        </picture>
        @break
        @endforeach
        <div class="flex flex-col  gap-[1rem] xl:p-12 items-center min-w-[100%] lg:min-w-fit lg:w-[100%]">
          <h3 class="text-3xl max-w-[90%] md:text-4xl lg:max-w-[55%] lg:text-5xl xl:text-4xl 2xl:text-5xl font-semibold text-gray-800 mb-[1rem]">{{ $product->product_name }}</h3>
          <!--Wishlist button-->
          <div class="relative">
            @if(!in_array($product->id, $wishListArray))
            <button wire:key="{{$index}}" wire:click="wishListItem({{$product->id}})"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3 c1.74 0 3.41 0.81 4.5 2.09 C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
              </svg></button>
            @else
            <button wire:key="{{$index}}" wire:click="wishListItem({{$product->id}})"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="black">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
           2 5.42 4.42 3 7.5 3 
           c1.74 0 3.41 0.81 4.5 2.09 
           C13.09 3.81 14.76 3 16.5 3 
           19.58 3 22 5.42 22 8.5 
           c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
              </svg></button>
            <div class="mt-3 rounded-lg w-[200px] right-[-80px] absolute border border-gray-200 bg-white p-3">
              <p class="text-sm text-gray-700">
                Za korištenje liste želja potrebno je da se
                <a href="/register" class="font-large text-black underline hover:opacity-70">
                  registrujete
                </a>
                tako da možete putem emaila da primite obavijesti o sniženjima.
              </p>
            </div>
            @endif
          </div>
          <span class="text-xl md:text-2xl 2xl:text-4xl">Popust vrijedi do: <span class="text-[#9E1B32]"> {{date('d-m-Y', strtotime($product->end_date))}}</span></span>
          <hr class="border-t-1 self-center row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[20%] col-span-1">
          <span class="text-[1.2rem] flex text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem] items-center">
            <p class="text-gray-900 font-bold text-xl md:text-2xl 2xl:text-4xl">Dostupno u:</p>
            @foreach ($product->colors as $index => $colors)
            <div class="m-1 border-2 shadow-md" wire:key="{{$index}}" style="width: 25px; height: 25px; background-color: {{$colors->hex_code}};
            border-radius: 50%;">
            </div>
            @endforeach

          </span>
          <span class="text-gray-900 font-bold text-xl md:text-2xl 2xl:text-4xl">
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
          <span class="text-gray-900 text-xl md:text-2xl 2xl:text-4xl font-bold">Spol:
            @foreach($product->genders as $gender)
            {{$gender->gender}}
            @endforeach
          </span>
          <span class="text-gray-900 font-bold text-xl md:text-2xl 2xl:text-4xl">Veličine:
            @php
            $uniqueSizes=collect($product->sizesVariant)->unique('size')
            @endphp
            @foreach($uniqueSizes as $sizes)
            {{$sizes->size}}
            @endforeach
          </span>
          @if(isset($product->discount) && !empty($product->discount))
          <span class="text-[#9E1B32] text-xl md:text-2xl 2xl:text-4xl bg-white border border-[#9E1B32] font-semibold px-2.5 py-1 rounded-md shadow-md"> Trenutni popust: - {{$product->discount}} %</span>
          <hr class="border-t-1  self-center row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[20%] col-span-1">
          <span class="text-xl xl:p-[1rem] md:text-2xl lg:text-4xl 2xl:text-5xl inline-flex items-center border border-amber-300 text-amber-700 font-medium px-3 py-1 rounded-full bg-amber-50 w-fit self-center">Cijena: {{number_format ($product->price-($product->price*($product->discount/100)), 2,'.',' ')}} $</span>
          <p class="line-through text-base mt-[1rem] md:text-sm  lg:text-2xl 2xl:text-3xl">Stara cijena: {{number_format($product->price, 2, '.', ' ')}} $</p>
          @endif
          <hr class="border-t-1 xl:w-[75%] row-start-1 col-span-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[20%] col-span-1">
          </hr>
          <button type="button" wire:click="buyProduct" class="text-white bg-gray-800 active:bg-gray-900 hover:bg-gray-700 
           font-semibold tracking-wide text-base 
           p-2.5 w-[25%] max-w-[25%]
           rounded-lg 
           transition-all duration-200 ease-in-out
           shadow-md hover:shadow-lg
           focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
           cursor-pointer">
            Kupi
          </button>
        </div>
      </div>
      @endforeach
      @else
      <span class="text-xl bg-red-100 text-gray-800 lg:text-2xl rounded-xl shadow-lg p-[3rem]">Naše posebne ponude su trenutno završene. Pratite nas — uskoro najavljujemo nove!</span>
      @endif
    </div>
    <button class="nav-btn nav-right lg:text-3xl text-white bg-gray-800 active:bg-gray-900 hover:bg-gray-700">&#10095;</button>
  </section>
</div>
<script>
  //To remove scroll buttons when no discount is detected
  const discountedItem = document.getElementById('discountedItem');
  const leftBtn = document.querySelector('.nav-left');
  const rightBtn = document.querySelector('.nav-right');
  if (!discountedItem) {
    leftBtn.classList.add("invisible");
    rightBtn.classList.add("invisible");
  }
</script>