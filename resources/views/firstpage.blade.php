<x-front-layout><!--First product page (after welcome.blade.php) view with the front.blade structure component in layouts folder-->
    <!--Header part-->
    <!--Back to top button-->
    <div class="relative" x-data="{ open: false }" >
        <a href="#top" class="fixed bottom-[5rem] lg:bottom-[6rem] right-4 bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl z-[5000] transition-all duration-300 p-2" aria-label="Back to top">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 lg:w-10 lg:h-10 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </a>
        <span x-on:click="open = ! open" class="fixed bottom-[8rem] lg:bottom-[10rem] right-4  bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl z-[5000] transition-all duration-300 p-2 group"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/message.svg') }}" alt="messages_icon" width="25" height="25">
            <span class="absolute bottom-[6px]  right-[3rem] lg:right-[4rem] bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                Contact us!
            </span>
        </span>
        <span class="fixed bottom-[11.5rem] z-[5000] lg:bottom-[14rem] border border border-blue-500 right-4" x-show="open" x-transition>
            <livewire:add-questions />
        </span>
    </div>

    <!--Main content-->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-[1rem] overflow-hidden">
        <div class="relative flex 2xl:group relative transition-all duration-300 ease-in-out transform 2xl:hover:scale-105 ">
            <picture class="w-full row-start-2 h-auto">
                <source media="(max-width: 460px)" srcset="{{ asset('storage/images/400x400/shop_male_400x600.webp') }}">
                <source media="(max-width: 640px)" srcset="{{ asset('storage/images/640x640/shop_male_640x960.webp') }}">
                <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/shop_male_800x1200.webp') }}">
                <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/1200x1200/shop_male_1200x1800.webp') }}">
                <img class="col-span-1 shadow-[0_8px_30px_rgba(0,0,0,0.12)] row-start-2 brightness-[70%] w-full  h-auto" loading="lazy" src="{{ asset('storage/images/200x200/shop_male_200x300.webp') }}" width=200 height=300 alt="men_models">
            </picture>
            <!--Navigation towards search and category-->
            <span class="absolute text-[calc(5rem+4vw)] sm:text-[5rem] md:text-[calc(6rem+2vw)] lg:text-[calc(8rem+2vw)] xl:text-[calc(10rem+1vw)] 2xl:text-[12rem] lg2:text-[15rem] text-white"><a href="/shop#explore">Explore</a></span>
        </div>
        <div class="relative flex 2xl:group relative transition-all 2xl:duration-300 ease-in-out transform 2xl:hover:scale-105 ">
            <picture class="w-full row-start-2 h-auto">
                <source media="(max-width: 460px)" srcset="{{ asset('storage/images/400x400/shop_female_400x600.webp') }}">
                <source media="(max-width: 640px)" srcset="{{ asset('storage/images/640x640/shop_female_640x960.webp') }}">
                <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/shop_female_800x1200.webp') }}">
                <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/1200x1200/shop_female_1200x1800.webp') }}">
                <img class="col-span-1 shadow-[0_8px_30px_rgba(0,0,0,0.12)] row-start-2 brightness-[70%] w-full  h-auto" loading="lazy" src="{{ asset('storage/images/200x200/shop_female_200x300.webp') }}" width=200 height=300 alt="women_models">
            </picture>
            <!--Navigation towards discounted items-->
            <span class="absolute text-[calc(5rem+4vw)] sm:text-[5rem] md:text-[calc(6rem+2vw)] lg:text-[calc(8rem+2vw)] xl:text-[calc(10rem+1vw)] 2xl:text-[12rem] lg2:text-[15rem] text-white"><a href="/shop#special-prices">Special prices</a></span>
        </div>
    </div>
    <!--Show all paginated products-->
    <livewire:show-products-front />
    <!--Show top 5 discounted products-->
    <livewire:show-discounted-products />
    <div class="relative flex items-end z-[-10]">
        <picture class="w-full row-start-2 h-auto">
            <source media="(max-width: 460px)" srcset="{{ asset('storage/images/400x400/shop_female_wide_400x267.webp') }}">
            <source media="(max-width: 640px)" srcset="{{ asset('storage/images/640x640/shop_female_wide_640x427.webp') }}">
            <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/shop_female_wide_800x533.webp') }}">
            <source media="(max-width: 1400px)" srcset="{{ asset('storage/images/1200x1200/shop_female_wide_1200x800.webp') }}">
            <source media="(min-width: 1400px)" srcset="{{ asset('storage/images/1400x1400/shop_female_wide_1400x933.webp') }}">
            <img class="w-[100vw] shadow-[0_8px_30px_rgba(0,0,0,0.12)] col-span-1  contrast-[0.5] lg:contrast-[1]  row-start-2  h-auto h-auto" loading="lazy" src="{{ asset('storage/images/200x200/shop_female_wide_200x300.webp') }}" alt="women_models" width=200 height=133>
        </picture>
        <span style="font-family: 'Playfair Display', serif; font-weight: 500; color: white;" class="absolute p-[1rem] text-[1rem] sm:text-[calc(1rem+2vw)] lg2:text-[3.5rem] text-white">At <strong>Melisa Fashion</strong>, we turn dreams into style you can wear. Guided by creativity and passion, we design fashion that empowers confidence and celebrates individuality.

            Dreams to Wear.

            <em>- Mirza Mehagić
                CEO, Melisa Fashion</em></span>
    </div>

    <hr class="border-t-4 row-start-1 col-span-2 mt-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
    <!--Footer part-->
</x-front-layout>