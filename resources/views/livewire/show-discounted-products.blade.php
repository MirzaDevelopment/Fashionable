<div id="special-prices" class="p-[0.5rem] bg-gray-100  mt-[3rem] z-[10]"><!--Livewire frontend component for showing discounted products on commerce page-->
  <div class="bg-gray-800 text-white py-6 px-8 rounded-lg shadow-lg max-w-6xl mx-auto">
    <h2 class="text-4xl lg:text-5xl font-extrabold text-center mb-4">Akcijske cijene</h2>
    <p class="text-center text-xl max-w-lg lg:text-2xl mx-auto mb-6">
      Uživajte u ekskluzivnim ponudama na najbolje ocijenjenim proizvodima. Požurite, ponude su vremenski ograničene!
    </p>
  </div>
  <section class="grid grid-rows-1  relative bg-gray-100 relative justify-center items-center">
    <button class="nav-btn nav-left absolute lg:text-[2rem] bg-gray-800 text-white">&#10094;</button>
    <div class="flex lg:mt-8 items-center w-[100%] md:w-[99%] lg:w-[100%] scroll-smooth snap-x snap-mandatory transition-transform m-auto duration-300 ease-in-out gap-[25px] py-5 overflow-y-auto  [scrollbar-width:none] [-ms-overflow-style:none]" id="carouselTrackDiscounted">
      @if($discountedProducts->isNotEmpty())
      @foreach ($discountedProducts as $product)
      <div id="discountedItem" class="lg:flex gap-[1rem] xl:flex-row flex flex-col place-content-evenly items-center min-w-[100%] snap-start rounded-xl overflow-hidden bg-white shadow-md  p-[1rem] rounded-lg  transform transition duration-300">
        @foreach ($product->images as $images) <img class="w-fit xl:w-[40%] lg:h-[700px] object-contain" loading="lazy" src="{{asset('storage/'.$images->image_800x800)}}" width="300" height=200 alt="product image">
        @break
        @endforeach
        <div class="flex flex-col items-center min-w-[100%] lg:min-w-fit lg:w-[100%]">
          <h3 class="text-[1.8rem] max-w-[90%] md:text-[2.5rem] lg:max-w-[55%] lg:text-[3rem] xl:text-[2rem] 2xl:text-[3rem] font-semibold text-gray-800 mb-[1rem]">{{ $product->product_name }}</h3>
          <span class="lg:text-[calc(1rem+1vw)] text-[1.2rem] md:text-[1.5rem] xl:text-[1.6rem] 2xl:text-[2rem]">Popust vrijedi do: <span class="text-[#9E1B32]"> {{date('d-m-Y', strtotime($product->end_date))}}</span></span>
          <hr class="border-t-1 self-center row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[20%] col-span-1">
          <span class="text-[1.2rem] flex text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">
            @foreach ($product->colors as $index => $colors)
            <div class="m-1 border-2 shadow-md" wire:key="{{$index}}" style="width: 25px; height: 25px; background-color: {{$colors->hex_code}};
            border-radius: 50%;">
            </div>
            @endforeach
          </span>
          <span class="text-gray-900 font-bold text-[1.2rem] lg:text-[calc(1rem+1vw)] xl:text-[1.6rem] 2xl:text-[2rem]  md:text-[1.5rem]">
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
          <span class="text-gray-900 text-[1.2rem] md:text-[1.5rem] font-bold lg:text-[calc(1rem+1vw)] 2xl:text-[2rem]  xl:text-[1.6rem]">Spol:
            @foreach($product->genders as $gender)
            {{$gender->gender}}
            @endforeach
          </span>
          <span class="text-gray-900 text-[1.2rem] md:text-[1.5rem] font-bold lg:text-[calc(1rem+1vw)] xl:text-[1.6rem] 2xl:text-[2rem]">Veličine:
            @php
            $uniqueSizes=collect($product->sizesVariant)->unique('size')
            @endphp
            @foreach($uniqueSizes as $sizes)
            {{$sizes->size}}
            @endforeach
          </span>
          @if(isset($product->discount) && !empty($product->discount))
          <span class="lg:text-[calc(1rem+1vw)] text-[1.2rem] md:text-[1.5rem] text-[#9E1B32] xl:text-[1.6rem] 2xl:text-[2rem]"> Trenutni popust: - {{$product->discount}} %</span>
          <hr class="border-t-1 self-center row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[20%] col-span-1">
          <span class="text-[1.2rem] md:text-[1.5rem] lg:text-[calc(1.5rem+1vw)] xl:text-[2rem] 2xl:text-[2.5rem] inline-flex items-center border border-amber-300 text-amber-700 font-medium px-3 py-1 rounded-full bg-amber-50 w-fit self-center">Cijena: {{number_format ($product->price-($product->price*($product->discount/100)), 2,'.',' ')}} $</span>
          <p class="line-through mt-[1rem] md:text-[1.2rem] xl:text-[1.5rem] lg:text-[calc(1rem+1vw)] 2xl:text-[1.8rem]">Stara cijena: {{number_format($product->price, 2, '.', ' ')}} $</p>
          @endif

          <hr class="border-t-1 row-start-1 col-span-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
          </hr>
        </div>
      </div>
      @endforeach
      @else
      <span class="text-xl bg-red-100 text-gray-800 lg:text-2xl rounded-xl shadow-lg p-[3rem]">Naše posebne ponude su trenutno završene. Pratite nas — uskoro najavljujemo nove!</span>
      @endif
    </div>
    <button class="nav-btn nav-right lg:text-[2rem] text-white bg-gray-800">&#10095;</button>
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