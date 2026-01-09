<!--Header component used in pages-->
<header class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <a href="/"><img src="{{ asset('storage/images/logo-no-background.svg') }}" alt="web_shop_logo" width="200" height="300" class=" sm:w-[300px] sm:h-[100px] lg:w-[600px] lg:h-[200px] 2xl:w-[900px] 2xl:h-[300px]"></a>
    <nav class="flex flex-row mt-[0.5rem] mb-[0.5rem]  2xl:mt-[0rem] 2xl:mb-[0rem] lg:flex-row-reverse flex-wrap" x-data="{ open: false }">
        <div class="lg:hidden">
            <img class="cursor-pointer lg:w-[100px]" src="{{ asset('storage/images/burger.svg') }}" alt="burger_menu" width="35" height="60" x-on:click="open = ! open" x-data="{ red: false }" x-bind:class="red ? ' bg-gray-100 text-white' : ''" @click="red = ! red">
            <div class="flex flex-col gap-1 lg:gap-5 xl:gap-6 lg:mt-6  xl:mt-6 2xl:gap-8 mt-[1rem] 2xl:mt-12 2xl:mb-[1.5rem] " x-show="open" x-transition>
                @if(Auth::user() && Auth::user()->role=="admin")
                <div>
                    <p class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]">Dobrodošli natrag, <a class="underline underline-offset-4 w-fit lg:underline-offset-[0.5rem] 2xl:underline-offset-[0.8rem] " href="{{ route('dashboard') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div><a href="route('logout')" class="text-[calc(1.25rem+1vw)]  relative  lg:text-[2rem]   relative " onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                            <a></div>
                </form>
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800 hover:text-gray-900 rounded-md relative lg:text-[2rem]   w-fit" href="">Korpa (0) <span class="absolute bottom-0  lg:top-11 2xl:top-14 left-0 w-0 h-[2px] lg:h-[3px] 2xl:h-[4px] bg-gray-900 transition-all"></span></a></div>
                @elseif(Auth::user() && Auth::user()->role=="guest")
                <div>
                    <p class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]">Dobrodošli natrag, <a class="underline lg:underline-offset-[0.5rem] 2xl:underline-offset-[0.8rem] underline-offset-4 w-fit" href="{{ route('dashboardusers') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div><a href="route('logout')" class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]  relative " onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Odjava') }}

                        </a></div>
                </form>
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800 hover:text-gray-900 rounded-md relative  lg:text-[2rem]  w-fit" href="">Cart (0)</a></div>
                @else
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800 hover:text-gray-900 rounded-md relative  lg:text-[2rem]  w-fit" href="{{ route('login') }}">
                        {{ __('Prijava') }}
                    </a></div>
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800  hover:text-gray-900 rounded-md relative  w-fit lg:text-[2rem] " href="{{ route('register') }}">
                        {{ __('Registracija') }}

                    </a></div>
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800 hover:text-gray-900 rounded-md relative  lg:text-[2rem]   w-fit" href="">Cart (0)</a></div>
                @endif
            </div>
        </div>
        <div class="hidden lg:block">
            <div class="flex flex-row gap-1 lg:gap-5 xl:gap-6  xl:mt-6  2xl:gap-8  items-end  2xl:mb-[1.5rem]">
                @if(Auth::user() && Auth::user()->role=="admin")
                <div>
                    <p class="text-[calc(1.25rem+1vw)]  lg:text-[2rem] text-gray-800">Dobrodošli natrag, <a class="underline text-gray-800  underline-offset-4 w-fit lg:underline-offset-[0.5rem] 2xl:underline-offset-[0.8rem] " href="{{ route('dashboard') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div><a href="route('logout')" class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]  relative  " onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Odjava') }}

                            <a></div>
                </form>
                <div><a class="text-[calc(1.25rem+1vw)] text-gray-800 hover:text-gray-900 rounded-md relative  lg:text-[2rem]  w-fit" href="">Korpa (0) </a></div>
                @elseif(Auth::user() && Auth::user()->role=="guest")
                <div>
                    <p class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]">Dobrodošli natrag, <a class="underline  lg:underline-offset-[0.5rem] 2xl:underline-offset-[0.8rem] underline-offset-4 w-fit" href="{{ route('dashboardusers') }}">{{Auth::user()->name}}.</a></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div><a href="route('logout')" class="text-[calc(1.25rem+1vw)]  lg:text-[2rem]  relative " onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Odjava') }}

                        </a></div>
                </form>
                <div><a class="text-gray-800 hover:text-gray-900 rounded-md relative lg:text-[2rem]  w-fit" href="">Cart (0)</a></div>
                @else
                <div><a class="text-gray-800 hover:text-gray-900 rounded-md relative lg:text-[2rem]  w-fit" href="{{ route('login') }}">
                        {{ __('Prijava') }}

                    </a></div>
                <div> <a class="text-gray-800  hover:text-gray-900 rounded-md relative  w-fit lg:text-[2rem] " href="{{ route('register') }}">
                        {{ __('Registracija') }}

                    </a></div>
                <div><a class=" text-gray-800 hover:text-gray-900 rounded-md relative lg:text-[2rem]  w-fit" href="">Korpa (0) </a></div>
                @endif
            </div>
        </div>
    </nav>
    <hr class="border-t-2 border-gray-800">
    </hr>
</header>