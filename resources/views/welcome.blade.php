<x-welcome-layout><!--Welcome page view with the front.blade structure component in layouts folder-->
    <!--Header fashionable-logo part is here-->
    <section>
        <a href="/"><img src="{{ asset('storage/images/fashionable-logo.png') }}" alt="fashionable-logo" width="500" height="500" fetchpriority="high"></a>
    </section>
    <!--Main content-->
    <hr class="border-t-2 border-gray-800 mb-[1rem]">
    </hr>
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl text-gray-900 font-bold leading-tight">
                    Kreiraj svoj modni webshop
                </h1>

                <ul class="mt-6 text-gray-800 items-center  text-lg list-disc list-inside space-y-4">
                    <li>Sve što ti treba za prodaju mode na jednom mjestu.</li>
                    <li>Kompletno softversko rješenje.</li>
                    <li>Isključivo na ex-yu jezicima.</li>
                </ul>

                <a href="#saznajVise" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                    Saznaj više
                </a>
                <a href="#demo" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                    Pogledaj demo
                </a>
                <a href="#demo" class="inline-block mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500  text-white px-6 py-3 text-sm font-semibold">
                    Započnite besplatno
                </a>
            </div>

            <!-- PROMO IMAGES -->
            <div class="grid grid-cols-3 grid-rows-2 gap-4 h-[600px]">
                <picture class="object-cover w-full h-full sm:row-span-2 col-span-1 hover:scale-105 transition duration-700">
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/fashionable-hero-4_320x400.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/fashionable-hero-4_400x500.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/fashionable-hero-4_640x800.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/fashionable-hero-4_800x1000.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/fashionable-hero-4_1200x1500.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/fashionable-hero-4_1400x1750.webp') }}">
                    <img class="shadow-xl rounded-xl object-cover w-full h-full row-span-2 col-span-1 hover:scale-105 transition duration-700" fetchpriority="high" loading="eager" src="{{ asset('storage/images/320x320/fashionable-hero-4_320x400.webp') }}" width=320 height=400 alt="female_model">
                </picture>
                <picture class="col-span-1 row-span-1 object-cover h-full w-full hover:scale-105 transition duration-700">
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/fashionable-hero-3_320x480.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/fashionable-hero-3_400x600.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/fashionable-hero-3_640x960.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/fashionable-hero-3_800x1200.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/fashionable-hero-3_1200x1800.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/fashionable-hero-3_1400x2100.webp') }}">
                    <img class="shadow-xl rounded-xl col-span-1 row-span-1 object-cover h-full w-full hover:scale-105 transition duration-700" fetchpriority="high" loading="eager" src="{{ asset('storage/images/320x320/fashionable-hero-3_320x480.webp') }}" width=320 height=480 alt="female_male_model">
                </picture>
                <picture class="object-cover col-span-1 row-span-1 h-full w-full hover:scale-105 transition duration-700">
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/fashionable-hero-1_320x400.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/fashionable-hero-1_400x500.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/fashionable-hero-1_640x800.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/fashionable-hero-1_800x1000.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/fashionable-hero-1_1200x1500.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/fashionable-hero-1_1400x1750.webp') }}">
                    <img class="shadow-xl rounded-xl object-cover col-span-1 row-span-1 h-full  w-full hover:scale-105 transition duration-700" fetchpriority="high" loading="eager" src="{{ asset('storage/images/320x320/fashionable-hero-3_320x400.webp') }}" width=320 height=400 alt="female_male_model">
                </picture>
                <picture class="object-cover h-full w-full col-span-3 sm:col-span-2 row-span-1 hover:scale-105 transition duration-700">
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/fashionable-hero-2_320x427.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/fashionable-hero-2_400x533.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/fashionable-hero-2_640x853.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/fashionable-hero-2_800x1067.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/fashionable-hero-2_1200x1600.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/fashionable-hero-2_1400x1867.webp') }}">
                    <img class="shadow-xl rounded-xl object-cover h-full w-full col-span-2 row-span-1 hover:scale-105 transition duration-700" fetchpriority="high" loading="eager" src="{{ asset('storage/images/320x320/fashionable-hero-2_320x427.webp') }}" width=320 height=427 alt="fashion_accessories">
                </picture>

            </div>

        </div>
    </section>
    <hr class="border-t-2 border-gray-800 mb-[1rem]">
    </hr>
    <section id="saznajVise" class="relative bg-white">
        <button class="nav-btn-1 nav-left absolute lg:text-3xl bg-gray-800 active:bg-gray-900 hover:bg-gray-700 ml-[1px] text-white">&#10094;</button>
        <div id="carouselTrack" class="flex scroll-smooth snap-x snap-mandatory transition-transform m-auto duration-300 ease-in-out overflow-y-auto  [scrollbar-width:none] [-ms-overflow-style:none]">
            <div id="carouselItem" class="flex flex-col place-content-evenly items-center min-w-[100%] py-20 px-6 snap-start rounded-xl overflow-hidden bg-white shadow-md rounded-lg  transform transition duration-300">
                <h1 class="text-5xl text-gray-900 font-bold leading-tight">
                    Zašto mi je potreban Fashionable?
                </h1>
                <ul class="mt-6 text-gray-800 items-center  text-lg list-disc list-inside space-y-4">
                    <li>Želiš podići online prodaju na novi - profesionalniji i sigurniji nivo!</li>
                    <li>Tražiš jednostavnu soluciju koja ti neće zaokupirati puno vremena.</li>
                    <li>Ostala moderna rješenja su preskupa ili prekomplikovana.</li>
                    <li>Bolje prenosiš poruku i svoj brend na domaćem jeziku.</li>
                    <li>Sve što je potrebno da imaš - tvoj proizvod, bilo kakvu konekciju ili uređaj.</li>
                    <li>Vrijeme je da tehnologija radi za tebe.</li>
                </ul>
                <div class="flex flex-row gap-12">
                    <a href="#demo" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                        Pogledaj demo
                    </a>
                    <a href="#demo" class="inline-block mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500  text-white px-6 py-3 text-sm font-semibold">
                        Započnite besplatno
                    </a>
                </div>
            </div>
            <div id="carouselItem" class="flex flex-col place-content-evenly items-center min-w-[100%] py-20 px-6 snap-start rounded-xl overflow-hidden bg-white shadow-md rounded-lg  transform transition duration-300">
                <h1 class="text-5xl text-gray-900 font-bold leading-tight">
                    Šta mi Fashionable nudi?
                </h1>
                <ul class="mt-6 text-gray-800 items-center  text-lg list-disc list-inside space-y-4">
                    <li> <strong>Potpuno besplatno korištenje i testiranje Fashionable softvera jedan mjesec, bez upisa ikakvih podataka sa kartica.</strong></li>
                    <li> Kompletno upravljanje proizvodom, korisnicima i procesom kupovine.</li>
                    <li> Upravljanje porukama klijenata uz instant slanje odogovora na mail bez izlaska iz programa.</li>
                    <li> Limit je vaša mašta - kreirajte, kategorije, proizvode, ponude bez ograničenja.</li>
                    <li> Moćni statistički pregledi svih aspekata prodaje.</li>
                    <li> Responsive dizajn sa fokusom na modu, odjeću, nakit, preglednost i fluidnost prodaje.</li>
                    <li> Fashionable pokreće moćni Laravel frejmvork sa Tailwindom i Livewire kao reaktivni frontend frejmvork brzine munje.</li>
                    <li> Fasihonable je u potpunosti ručno iskodirana aplikacija i nadograđuje se redovno.</li>
                    <li> Fasihonable prati sve najbolje i state of the art programerske prakse i dostupan je na githubu.</li>
                    <li> Fashionable se pokreće na moćnom Digital Ocean VPS serveru povezanim sa Cloudflare DNS-om uz potporu Laravel Forge-a.</li>
                </ul>
                <div class="flex flex-row gap-12">
                    <a href="#demo" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                        Pogledaj demo
                    </a>
                    <a href="#demo" class="inline-block mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500  text-white px-6 py-3 text-sm font-semibold">
                        Započnite besplatno
                    </a>
                </div>
            </div>
            <div id="carouselItem" class="flex flex-col place-content-evenly items-center min-w-[100%] py-20 px-6 snap-start rounded-xl overflow-hidden bg-white shadow-md rounded-lg  transform transition duration-300">
                <h1 class="text-5xl text-gray-900 font-bold leading-tight">
                    Šta Fashionable nudi mojim kupcima?
                </h1>
                <ul class="mt-6 text-gray-800 items-center  text-lg list-disc list-inside space-y-4">
                    <li>Jednostavna i sigurna registracija manuelno ili putem google računa.</li>
                    <li>Instant pretraga bilo putem "pretraži" opcije ili putem kategorija proizvoda.</li>
                    <li> Lista želja sa trenutnim mail obaviještenjem kada je proizvod na popustu.</li>
                    <li> Brza i transparentna kupovina - kupac će u potpunosti znati da li tražena kombinacija proizvoda postoji na stanju.</li>
                    <li> Statistika kupovina - pregled svih obavljenih kupovina na sajtu.</li>
                    <li> E-mail obaviještenje o obavljenoj kupovini sa pregledom kupljenog proizvoda.</li>
                    <li> Komunikacija putem kontakt forme i dobijanja odgovora na e-mail.</li>
                    <li> Maksimalna zaštita kupaca i sigurnost podataka - svi podaci su šifrirani i zaštićeni naprednim Laravel funkcijama.</li>
                </ul>
                <div class="flex flex-row gap-12">
                    <a href="#demo" class="inline-block mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                        Pogledaj demo
                    </a>
                    <a href="#demo" class="inline-block mt-8 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500  text-white px-6 py-3 text-sm font-semibold">
                        Započnite besplatno
                    </a>
                </div>
            </div>
        </div>
        <button class="nav-btn-1 nav-right lg:text-3xl text-white bg-gray-800 active:bg-gray-900 hover:bg-gray-700 mr-[1px]">&#10095;</button>
    </section>
    <!-- APP SCREENSHOTS -->
    <section class="relative">
        <div class="grid  mx-auto px-6 py-20 grid-cols-1 sm:grid-cols-2 gap-12">
            <div class="flex flex-col items-center min-w-[100%]  snap-start bg-white  transform transition duration-300">
                <p><strong>Slika: Pretraživanje proizvoda po kategorijama</strong></p>
                <picture>
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/category_search_products_320x195.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/category_search_products_400x244.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/category_search_products_640x390.webp') }}">
                    <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/category_search_products_800x488.webp') }}">
                    <img class="shadow-xl rounded-xl mx-auto max-w-8xl w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/category_search_products_320x195.webp') }}" width=320 height=150 alt="category_product_search_screenshot">
                </picture>
            </div>
            <div class="flex flex-col items-center min-w-[100%]  snap-start bg-white  transform transition duration-300">
                <p><strong>Slika: Modificiranje proizvoda</strong></p>
                <picture>
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/edit_product_320x150.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/edit_product_400x188.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/edit_product_640x300.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/edit_product_800x375.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/edit_product_1200x563.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/edit_product_1400x656.webp') }}">
                    <img class="shadow-xl rounded-xl mx-auto max-w-8xl w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/edit_product_320x150.webp') }}" width=320 height=150 alt="edit_product_screenshot">
                </picture>
            </div>
            <div class="flex flex-col items-center min-w-[100%]  snap-start  bg-white  transform transition duration-300">
                <p><strong>Slika: Kontakt forma</strong></p>
                <picture>
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/contact_form_320x152.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/contact_form_400x191.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/contact_form_640x305.webp') }}">
                    <source media="(max-width: 1024px)" srcset="{{ asset('storage/images/800x800/contact_form_800x381.webp') }}">
                    <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/contact_form_1200x572.webp') }}">
                    <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/contact_form_1400x667.webp') }}">
                    <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/contact_form_320x152.webp') }}" width=320 height=400 alt="contact_form_screenshot">
                </picture>
            </div>
            <div class="flex flex-col items-center min-w-[100%] snap-start bg-white  transform transition duration-300">
                <p><strong>Slika: Upravljanje količinama</strong></p>
                <picture>
                    <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/edit_stock_320x393.webp') }}">
                    <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/edit_stock_400x491.webp') }}">
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/edit_stock_640x786.webp') }}">
                    <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/edit_stock_800x982.webp') }}">
                    <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/edit_stock_320x393.webp') }}" width=320 height=400 alt="stock_management_screenshot">
                </picture>
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