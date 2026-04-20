<x-welcome-layout><!--Welcome page view with the front.blade structure component in layouts folder-->
    <!--Header fashionable-logo part is here-->
    <section>
        <a href="/"><img src="{{ asset('storage/images/fashionable-logo.png') }}" alt="fashionable-logo" width="500" height="500" class=""></a>
    </section>
    <!--Main content-->
    <!--Main content-->
    <hr class="border-t-2 border-gray-800 mb-[1rem]">
    </hr>
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-12 items-center">
            <!-- TEXT -->
            <div>
                <h1 class="text-5xl text-gray-900 font-bold leading-tight">
                    Kreiraj svoj modni webshop
                </h1>

                <p class="mt-6 text-gray-800 text-lg">
                    Sve što ti treba za prodaju mode na jednom mjestu.
                </p>
                <p class="mt-6 text-gray-800 text-lg">
                    Isključivo na ex-yu jezicima.
                </p>

                <a href="#" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                    Saznaj više
                </a>
                <a href="#demo" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                    Pogledaj demo
                </a>
            </div>

            <!-- IMAGE -->
            <div class="grid grid-cols-3 grid-rows-2 gap-4 h-[600px] ">
                <img src="{{ asset('storage/images/fashionable-hero-4.webp') }}" class=" shadow-xl rounded-xl object-cover w-full h-full row-span-2 col-span-1 hover:scale-105 transition duration-700">
                <img src="{{ asset('storage/images/fashionable-hero-3.webp') }}" class="shadow-xl rounded-xl col-span-1 row-span-1 object-cover h-full w-full hover:scale-105 transition duration-700">
                <img src="{{ asset('storage/images/fashionable-hero-1.webp') }}" class="shadow-xl rounded-xl object-cover col-span-1 row-span-1 h-full  w-full hover:scale-105 transition duration-700">
                <img src="{{ asset('storage/images/fashionable-hero-2.webp') }}" class=" shadow-xl rounded-xl object-cover h-full w-full col-span-2 row-span-1 hover:scale-105 transition duration-700">

            </div>

        </div>
    </section>
    <hr class="border-t-2 border-gray-800 mb-[1rem]">
    </hr>
    <section id="demo" class="flex justify-center">
        <a href="/"><img src="{{ asset('storage/images/melisa_fashion_logo_header.svg') }}" alt="web_shop_logo" width="300" height="200" class=" sm:w-[300px] sm:h-[100px] lg:w-[600px] lg:h-[200px] 2xl:w-[900px] 2xl:h-[300px]"></a>
    </section>
    <section class="xl:flex bg-white xl:hover:bg-slate-100 transition-colors duration-200 justify-center items-center gap-[2rem] flex-row">
        <div class="relative flex flex-col  justify-center items-center">
            <picture class="w-full col-span-1 col-start-1 row-start-2 h-auto">
                <source media="(max-width: 460px)" srcset="{{ asset('storage/images/640x640/torbice_600x401.webp') }}">
                <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/torbice_800x534.webp') }}">
                <source media="(max-width: 1400px)" srcset="{{ asset('storage/images/1200x1200/torbice_1200x801.webp') }}">
                <source media="(min-width: 1400px)" srcset="{{ asset('storage/images/1400x1400/torbice_1400x933.webp') }}">
                <img class="w-[100vw] col-span-1 row-start-2 h-auto" src="{{ asset('storage/images/320x320/torbice_320x214.webp') }}" width=1200 height=801 alt="female_purses" loading="eager" fetchpriority="high">
            </picture>
            <h2 class="font-playfair p-[1rem] absolute text-6xl sm:text-7xl text-white md:text-[6rem] lg:text-[7rem] 2xl:text-[11rem] leading-tight">
                Melisa Webshop
                <p class="text-4xl font-bold 2xl:text-6xl">(Demo)</p>
            </h2>

        </div>
        <div class="sm:mt-[2rem]  xl:mt-0 min-w-[31%]">
            <a class="text-gray-800 xl:leading-tight break-normal hover:text-gray-900 text-3xl sm:text-4xl rounded-md relative group w-fit lg:text-[3rem] xl:text-[4rem] 2xl:text-[6rem]" href="{{ route('firstpage') }}">
                {{ __('Ulaz u online prodavnicu') }}
                <span class="absolute top-[36px] left-0 lg:top-[3.5rem] xl:top-auto xl:left-5 w-0 h-[2px] lg:h-[3px] 2xl:h-[4px] bg-gray-800 transition-all group-hover:w-full"></span>
            </a>
        </div>
    </section>
    <hr class="border-t-4 row-start-1 col-span-2 mt-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
    <!--Footer part is here-->
</x-welcome-layout>