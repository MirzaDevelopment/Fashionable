<x-front-layout><!--First product page (after welcome.blade.php) view with the front.blade structure component in layouts folder-->
    <!--Header part-->
    <!--Main content-->
    <div class="">
        <div class="relative flex 2xl:group relative min-h-[38vh]">
                <picture class="w-full row-start-2 h-auto relative">
                <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/shop_female_320x213.webp') }}">
                <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/shop_female_400x267.webp') }}">
                <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/shop_female_640x427.webp') }}">
                <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/shop_female_800x533.webp') }}">
                <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/shop_female_1200x800.webp') }}">
                <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/shop_female_1400x933.webp') }}">
                <img class="col-span-1 shadow-[0_8px_30px_rgba(0,0,0,0.12)] row-start-2  w-full h-auto" fetchpriority="high" loading="eager" src="{{ asset('storage/images/200x200/shop_female_200x134.webp') }}" width=200 height=300 alt="men_models">
                </picture>
            <!--Navigation towards search and category-->
            <span class="absolute top-[25px] text-7xl sm:text-8xl  lg:text-[calc(7rem+2vw)] xl:text-[calc(9rem+1vw)] 2xl:text-[12rem] lg2:text-[25rem] text-white"><a href="/shop#explore">Istraži</a></span>
        </div>
       
    </div>
    <!--Back to top button and contact form-->
    <div class="relative" x-data="{ open: false }">
        <a href="#top" class="fixed bottom-[5rem] lg:bottom-[6rem] right-4 bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl z-[5000] transition-all duration-300 p-2" aria-label="Back to top">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 lg:w-10 lg:h-10 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </a>
        <span x-on:click="open = ! open" class="fixed bottom-[8rem] lg:bottom-[10rem] right-4  bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl z-[5000] transition-all duration-300 p-2 group"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/message.svg') }}" alt="messages_icon" width="25" height="25">
            <span class="absolute bottom-[6px]  right-[3rem] lg:right-[4rem] bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                Javite nam se!
            </span>
        </span>
        <span class="fixed bottom-[11.5rem] z-[5000] lg:bottom-[14rem] border border border-blue-500 right-4" x-show="open" x-transition>
            <livewire:add-questions />
        </span>
    </div>
    <!--Show all paginated products-->
    <livewire:show-products-front />
    <div class="">
        <div class="relative flex 2xl:group relative">
               <picture class="w-full row-start-2 h-auto relative">
                <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/shop_male_320x213.webp') }}">
                <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/shop_male_400x267.webp') }}">
                <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/shop_male_640x427.webp') }}">
                <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/shop_male_800x533.webp') }}">
                <source media="(min-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/shop_male_1200x800.webp') }}">
                <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/shop_male_1400x933.webp') }}">
                <img class="col-span-1 shadow-[0_8px_30px_rgba(0,0,0,0.12)] row-start-2  w-full  h-640px" loading="lazy" src="{{ asset('storage/images/200x200/shop_male_200x134.webp') }}" width=200 height=300 alt="men_models">
            </picture>
            </picture>
            <!--Navigation towards discounted items-->
            <span class="absolute top-[25px] text-7xl sm:text-8xl lg:text-[calc(7rem+2vw)] xl:text-[calc(9rem+1vw)] 2xl:text-[12rem] lg2:text-[25rem] text-white"><a href="/shop#special-prices">Popusti</a></span>
        </div>
       
    </div>
     <!--Show top 5 discounted products-->
    <livewire:show-discounted-products />
    <hr class="border-t-4 row-start-1 col-span-2 mt-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
    <!--Footer part-->
</x-front-layout>