<!--Header component used in pages-->
<header class="mx-auto py-6 px-4 sm:px-6 w-fit lg:px-8">
    <img src="{{ asset('storage/images/melisa_fashion_logo_header.svg') }}" fetchpriority="high" alt="web_shop_logo" width="300" height="200" class=" sm:w-[300px] sm:h-[100px] lg:w-[600px] lg:h-[200px] 2xl:w-[900px] 2xl:h-[300px]">
    <nav class="flex flex-row mt-[0.5rem] mb-[0.5rem]  2xl:mt-[0rem] 2xl:mb-[0rem] lg:flex-row-reverse flex-wrap" x-data="{ open: false }">
        <div class="lg:hidden">
            <img class="cursor-pointer lg:w-[100px]" src="{{ asset('storage/images/burger.svg') }}" alt="burger_menu" width="35" height="60" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-slate-100 text-white' : ''" @click="red = ! red">
            <div class="flex flex-col gap-1 lg:gap-5 xl:gap-6 lg:mt-6  xl:mt-6 2xl:gap-8 mt-[1rem] 2xl:mt-12 2xl:mb-[1.5rem] " x-show="open" x-transition>
                @if(Auth::user() && Auth::user()->role=="admin")
                <div>
                    <p class="text-2xl  lg:text-4xl">Dobrodošli natrag, <a class="w-fit" href="{{ route('dashboard') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="flex flex-col gap-[0.5rem] items-start">
                        <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="route('logout')"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/logouticon.svg') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" alt="messages_icon" width="25" height="25"></a></div>
                        <div>
                            <p>Odjava</p>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col gap-[0.5rem] items-start">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @elseif(Auth::user() && Auth::user()->role=="gost")
                <div>
                    <p class="text-2xl  lg:text-4xl">Dobrodošli natrag, <a class="w-fit" href="{{ route('dashboardusers') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="flex flex-col gap-[0.5rem] items-center">
                        <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="route('logout')"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/logouticon.svg') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" alt="messages_icon" width="25" height="25"></a></div>
                        <div>
                            <p>Odjava</p>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @else
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="{{ route('login') }}">
                            <img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/loginicon.svg') }}" alt="messages_icon" width="25" height="25">
                        </a></div>
                    <div>
                        <p>Prijavi se</p>
                    </div>
                </div>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"> <a href="{{ route('register') }}">
                            <img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/newuser.svg') }}" alt="messages_icon" width="25" height="25">
                        </a></div>
                    <div>
                        <p>Registracija</p>
                    </div>
                </div>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="hidden lg:block">
            <div class="flex flex-row gap-1 lg:gap-5 xl:gap-6  xl:mt-6  2xl:gap-8  items-end  2xl:mb-[1.5rem]">
                @if(Auth::user() && Auth::user()->role=="admin")
                <div>
                    <p class="text-2xl  lg:text-4xl text-gray-800">Dobrodošli natrag, <a class=" text-gray-800  " href="{{ route('dashboard') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div class="flex flex-col gap-[0.5rem] items-center">
                        <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="route('logout')"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/logouticon.svg') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" alt="messages_icon" width="25" height="25"></a></div>
                        <div>
                            <p>Odjava</p>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @elseif(Auth::user() && Auth::user()->role=="gost")
                <div>
                    <p class="text-2xl  lg:text-4xl">Dobrodošli natrag, <a class="w-fit" href="{{ route('dashboardusers') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div class="flex flex-col gap-[0.5rem] items-center">
                        <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="route('logout')"><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/logouticon.svg') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" alt="messages_icon" width="25" height="25"></a></div>
                        <div>
                            <p>Odjava</p>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @else
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href="{{ route('login') }}">
                            <img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/loginicon.svg') }}" alt="messages_icon" width="25" height="25">
                        </a></div>
                    <div>
                        <p>Prijavi se</p>
                    </div>
                </div>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"> <a href="{{ route('register') }}">
                            <img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/newuser.svg') }}" alt="messages_icon" width="25" height="25">
                        </a></div>
                    <div>
                        <p>Registracija</p>
                    </div>
                </div>
                <div class="flex flex-col gap-[0.5rem] items-center">
                    <div class="bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl p-3"><a href=""><img class="cursor-pointer w-6 lg:w-10 lg:h-10 h-6" src="{{ asset('storage/images/carticon.svg') }}" alt="messages_icon" width="25" height="25"></a></div>
                    <div>
                        <p>Korpa</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </nav>
    <hr class="border-t-2 border-gray-800">
    </hr>
    <nav x-data="{ open: false }" class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/70 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex h-16 gap-6 items-center justify-between">

                <!-- Logo -->
                <a href="/" class="text-xl font-semibold tracking-wide text-gray-900">
                    FASHIONABLE
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="/shop#explore" class="text-sm font-medium text-gray-800 hover:text-black transition">
                        Kategorije i pretraga
                    </a>
                    <a href="/shop#special-prices" class="text-sm font-medium text-gray-800 hover:text-black transition">
                        Posebne ponude
                    </a>
                    <a href="/shop#special-prices" class="text-sm font-medium text-gray-800 hover:text-black transition">
                        Najnovija linija
                    </a>
                    <a href="/shop#special-prices" class="text-sm font-medium text-gray-800 hover:text-black transition">
                        Najbolje cijene
                    </a>
                    <a href="/sho#footer" class="text-sm font-medium text-gray-800 hover:text-black transition">
                        O nama
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden py-4 space-y-4 flex flex-col">

                <a href="/shop#explore" class="block text-sm text-gray-800 hover:text-black">
                    Kategorije proizvoda
                </a>
                <a href="/shop#special-prices" class="text-sm font-medium text-gray-800 hover:text-black transition">
                    Posebne ponude
                </a>
                <a href="/shop#special-prices" class="text-sm font-medium text-gray-800 hover:text-black transition">
                    Najnovija linija
                </a>
                <a href="/shop#special-prices" class="block text-sm text-gray-800 hover:text-black">
                    Najbolje cijene
                </a>
                <a href="/shop/#footer" class="block text-sm text-gray-800 hover:text-black">
                    O nama
                </a>
            </div>
        </div>
    </nav>
    <hr class="border-t-2 border-gray-800">
    </hr>
</header>