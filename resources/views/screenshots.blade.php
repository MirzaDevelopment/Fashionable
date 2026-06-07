 <x-welcome-layout><!--Welcome page view with the front.blade structure component in layouts folder-->
     <!-- APP SCREENSHOTS -->
     <h1 class="text-4xl p-4 lg:p-20 text-gray-900 font-bold leading-tight">
         Kako to izgleda unutar Fashionable aplikacije?
     </h1>
     <section class="relative flex flex-col items-center w-fit">
         <div class="grid  mx-auto px-6 py-20 grid-cols-1 sm:grid-cols-2 gap-12">
             <div class="flex flex-col items-center min-w-[100%]  snap-start bg-white">
                 <p><strong>Slika: Pretraživanje proizvoda po kategorijama</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/category_search_products_320x195.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/category_search_products_400x244.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/category_search_products_640x390.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/category_search_products_800x488.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/category_search_products_320x195.webp') }}" width=320 height=150 alt="category_product_search_screenshot">
                 </picture>
             </div>
             <div class="flex flex-col items-center min-w-[100%]  snap-start bg-white">
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
             <div class="flex flex-col items-center min-w-[100%]  bg-white">
                 <p><strong>Slika: Upravljanje kategorijama</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/category_management_320x266.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/category_management_400x333.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/category_management_640x532.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/category_management_800x665.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/category_management_320x266.webp') }}" width=320 height=400 alt="category_management_screenshot">
                 </picture>
             </div>

             <div class="flex flex-col items-center min-w-[100%]  bg-white">
                 <p><strong>Slika: Upravljanje količinama</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/edit_stock_320x393.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/edit_stock_400x491.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/edit_stock_640x786.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/640x640/edit_stock_640x786.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/edit_stock_320x393.webp') }}" width=320 height=400 alt="stock_management_screenshot">
                 </picture>
             </div>
             <div class="flex flex-col items-center min-w-[100%] bg-white">
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
             <div class="flex flex-col items-center min-w-[100%] bg-white">
                 <p><strong>Slika: Upravljanje pitanjima i komentarima</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/contact_admin_320x175.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/contact_admin_400x219.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/contact_admin_640x350.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/contact_admin_800x437.webp') }}">
                     <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/contact_admin_1200x656.webp') }}">
                     <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/contact_admin_1400x766.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/contact_admin_320x175.webp') }}" width=320 height=400 alt="contact_admin_panel">
                 </picture>
             </div>
             <div class="flex flex-col items-center min-w-[100%] bg-white">
                 <p><strong>Slika: Pregled proizvoda prije dodavanja</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/product_review_320x238.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/product_review_400x298.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/product_review_640x476.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/product_review_800x595.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/contact_admin_320x175.webp') }}" width=320 height=400 alt="contact_admin_panel">
                 </picture>
             </div>
             <div class="flex flex-col items-center min-w-[100%] bg-white">
                 <p><strong>Slika: Pretraga i upravljanje proizvodima</strong></p>
                 <picture>
                     <source media="(max-width: 320px)" srcset="{{ asset('storage/images/320x320/show_products_320x223.webp') }}">
                     <source media="(max-width: 480px)" srcset="{{ asset('storage/images/400x400/show_products_400x278.webp') }}">
                     <source media="(max-width: 768px)" srcset="{{ asset('storage/images/640x640/show_products_640x445.webp') }}">
                     <source media="(min-width: 1024px)" srcset="{{ asset('storage/images/800x800/show_products_800x556.webp') }}">
                     <source media="(max-width: 1280px)" srcset="{{ asset('storage/images/1200x1200/show_products_1200x835.webp') }}">
                     <source media="(min-width: 1536px)" srcset="{{ asset('storage/images/1400x1400/show_products_1400x766.webp') }}">
                     <img class="shadow-xl rounded-xl mx-auto max-w-8xl  w-full h-full" loading="lazy" src="{{ asset('storage/images/320x320/show_products_320x175.webp') }}" width=320 height=400 alt="contact_admin_panel">
                 </picture>
             </div>
         </div>
         <hr class="border-t-2 border-gray-800 mb-[1rem] w-[100%]">
         </hr>
         <p class="text-4xl p-4 text-gray-900 font-bold leading-tight">I mnogo više...</p>
         <div class="flex flex-row w-[80%] gap-2 lg:w-[25%] justify-center">
            <a href="/" class="inline-block w-fit mb-8 lg:mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                    Natrag
                </a>
             <a href="/#demo" class="inline-block w-fit mb-8 lg:mt-8 bg-gray-800 active:bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 text-sm font-semibold">
                 Isprobaj demo
             </a>
         </div>
     </section>
 </x-welcome-layout>