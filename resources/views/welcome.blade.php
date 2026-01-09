<x-front-layout><!--Welcome page view with the front.blade structure component in layouts folder-->
     <!--Header part is here-->
    <!--Main content-->
    <div class="xl:flex bg-white xl:hover:bg-gray-100 transition-colors duration-200 justify-center items-center gap-[2rem] flex-row">
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
                    {{ __('Pretraži našu kolekciju') }}
                    <span class="absolute top-[36px] left-0 lg:top-[3.5rem] xl:top-auto xl:left-5 w-0 h-[2px] lg:h-[3px] 2xl:h-[4px] bg-gray-900 transition-all group-hover:w-full"></span>
                </a>
            </div>
        </div>
        
        <div class="carousel-container">
            <button class="text-base text-[2rem] nav-btn opacity-[50%] nav-left">&#10094;</button>
            <div class="carousel-track" id="carouselTrack">
                <!-- Brand logos-->
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/gucci-1-logo-svg-vector.svg') }}" alt="gucci-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/vogue-logo-svg-vector.svg') }}" alt="vogue-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/calvin-klein-logo.svg') }}" alt="calvin-klein-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/adidas-4-logo-svg-vector.svg') }}" alt="adidas-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/chanel-2-logo-svg-vector.svg') }}" alt="chanel-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/prada-logo.svg') }}" alt="prada-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/cartier-2-logo-svg-vector.svg') }}" alt="cartier-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/versace-medusa-logo-svg-vector.svg') }}" alt="versace-logo" width="200" height="300" />
                </div>

                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/tiffany-co-logo-svg-vector.svg') }}" alt="tiffany-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/louis-vuitton-1-logo-svg-vector.svg') }}" alt="louis-vuitton-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/zara-logo-svg-vector.svg') }}" alt="zara-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/vans-3-logo-svg-vector.svg') }}" alt="vans-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" fetchpriority="low" src="{{ asset('storage/images/hugo-boss-logo.svg') }}" alt="hugo-bos-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/gucci-1-logo-svg-vector.svg') }}" alt="gucci-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/vogue-logo-svg-vector.svg') }}" alt="vogue-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/calvin-klein-logo.svg') }}" alt="calvin-klein-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/adidas-4-logo-svg-vector.svg') }}" alt="adidas-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/chanel-2-logo-svg-vector.svg') }}" alt="chanel-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/prada-logo.svg') }}" alt="prada-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/cartier-2-logo-svg-vector.svg') }}" alt="cartier-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/versace-medusa-logo-svg-vector.svg') }}" alt="versace-logo" width="200" height="300" />
                </div>

                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/tiffany-co-logo-svg-vector.svg') }}" alt="tiffany-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/louis-vuitton-1-logo-svg-vector.svg') }}" alt="louis-vuitton-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/zara-logo-svg-vector.svg') }}" alt="zara-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/vans-3-logo-svg-vector.svg') }}" alt="vans-logo" width="200" height="300" />
                </div>
                <div class="carousel-item">
                    <img loading="lazy" src="{{ asset('storage/images/hugo-boss-logo.svg') }}" alt="hugo-bos-logo" width="200" height="300" />
                </div>
            </div>
            <button class="nav-btn nav-right opacity-[50%] text-[2rem]">&#10095;</button>
        </div>
    <hr>
    </hr>
    <hr class="border-t-4 row-start-1 col-span-2 mt-2 lg:mt-4 2xl:mt-8 border-gray-800 w-[100%] col-span-1">
 <!--Footer part is here-->
</x-front-layout>