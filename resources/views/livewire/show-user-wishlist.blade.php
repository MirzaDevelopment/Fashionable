<div>
   <section class="flex flex-col bg-white gap-[1rem] xl:gap-[2rem]  justify-items-center items-center mt-[1rem] p-[0.5rem] mb-[3rem]">
         @if(count($products)==0)
        <p class="text-xl lg:text-2xl text-[#D32F2F]">{{$empty}}</p>
        @endif
      @isset($products)
      @foreach ($products as $key=> $product)
      <div class="flex flex-col  cursor-pointer place-content-evenly  hover:shadow-lg shadow-black/10 transition-all duration-300 ease-out  items-center min-w-[100%] min-h-[100%] gap-[1rem] xl:gap-[2rem] max-w-xs overflow-hidden bg-white p-[1rem]">
         <div class="">
            <span class="flex flex-row  text-[1.2rem] mb-[1rem] text-gray-900 font-bold lg:text-[calc(1rem+1vw)] lg2:text-[2.2rem]">
               @foreach ($product->colors as $index => $colors)
               <div class="m-1 border-2 shadow-md" wire:key="{{$index}}" style="width: 25px; height: 25px; background-color: {{$colors->hex_code}};
            border-radius: 50%;">
               </div>
               @endforeach
         </div>
         </span>
         <!--Images-->
         @foreach ($product->images as $images)
         <picture>
            <source media="(max-width: 320px)" srcset="{{ asset('storage/'.$images->image_320x320) }}">
            <source media="(max-width: 640px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
            <source media="(max-width: 1023px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
            <source media="(min-width: 1024px)" srcset="{{ asset('storage/'.$images->image_400x400) }}">
            <img class="object-cover" loading="lazy" fetchpriority="low" decoding="async" src="{{ asset('storage/'.$images->image_400x400)}}" width="400" height="600" alt="product image">
         </picture>
         @break
         @endforeach
         <button wire:click="deleteWishlistItem({{$product->id}})" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Ukloni sa liste želja</button>
      </div>
      <hr class="border-t-1 row-start-1 col-span-2 mt-2 mb-[2rem] lg:mt-4 2xl:mt-8 border-gray-800 w-[25%] col-span-1">
      <h3 class="text-xl lg:text-3xl 2xl:text-4xl font-semibold text-gray-800">{{ $product->product_name }}</h3>
      <span class="text-sm text-gray-900 lg:text-2xl lg2:text-3xl">
         @foreach ($product->materials as $key=> $materials)
         @if($key==0)
         <span class="bg-slate-200 text-black p-2">{{$materials->material}}</span>
         @elseif($key>0)
         <span class="ml-[-4px]">,</span> <span class="bg-slate-200 text-black p-2">{{$materials->material}}</span>
         @else
         <span class="bg-slate-200 text-black p-2">{{$materials->material}}</span>
         @endif
         @endforeach
      </span>
      <span class="text-gray-900  text-sm lg:text-2xl lg2:text-3xl">Veličine:
         @php
         $uniqueSizes=collect($product->sizesVariant)->unique('size')
         @endphp
         @foreach($uniqueSizes as $sizes)
         <span class="bg-slate-200 p-2">{{$sizes->size}}</span>
         @endforeach
      </span>
      @if(isset($product->discount) && !empty($product->discount) && $currentDate->lte($product->end_date))
      <span class="text-sm lg:text-2xl lg2:text-3xl text-[#9E1B32]"> Trenutni popust: - {{$product->discount}} %</span>
      <span class="text-sm lg:text-2xl lg2:text-3xl  border border-amber-300 text-amber-700 
            medium px-3 py-1 rounded-full bg-amber-50">Cijena: {{number_format ($product->price-($product->price*($product->discount/100)), 2,'.',' ')}} $</span>
      <p class="line-through text-sm lg:text-xl 2xl:text-2xl">Stara cijena: {{number_format($product->price, 2, '.', ' ')}} $</p>
      @else
      <span class="text-sm lg:text-2xl lg2:text-3xl text-gray-900 font-bold ">Cijena: {{$product->price}} $</span>
      @endif

      <hr class="border-t-1 mt-[1rem] row-start-1 col-span-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
      </hr>
      @endforeach
      @endisset

   </section>
   <div id="frontPagination" class="mr-[2rem] ml-[2rem] mb-[3rem]">
      {{ $products->links() }}
   </div>
   <a class="col-start-1 lg:col-span-2 lg2:col-start-1 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dashboardusers') }}" wire:navigate>Natrag na ploču</a>
</div>