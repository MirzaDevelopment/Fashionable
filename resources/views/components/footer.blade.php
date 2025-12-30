<!--Footer component used in pages-->
<footer class="flex items-center bg-gray-100 md:p-[3rem]  flex-col xl:grid grid-flow-col xl:items-baseline  p-3.5 text-center">
    <nav class="grid grid-flow-col grid-rows-3 sm:grid-rows-2 items-center xl:flex xl:flex-col gap-[1rem] xl:col-start-1 xl:row-start-1 lg:mb-[rem]">
        <a class="sm:text-2xl  font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/terms.html') }}">Uslovi korištenja</a>
        <a class="sm:text-2xl font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/privacypolicy.html') }}">Politika privatnosti</a>
        <a class="sm:text-2xl font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/returnpolicy.html') }}">Politika naplate</a>
        <a class="sm:text-2xl font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/cookiespolicy.html') }}">Politika kolačića</a>
        <a class="sm:text-2xl font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/acceptableusepolicy.html') }}">Pravila prihvatljive upotrebe</a>
        <a class="sm:text-2xl font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ asset('storage/disclaimer.html') }}">Disclaimer</a>
        <a class="sm:text-2xl  font-bold lg:text-[1.8rem]  2xl:text-[2rem]" href="{{ route('firstpage') }}">Webshop DEMO</a>
    </nav>
    <nav class="flex flex-col mt-[2rem] gap-[1rem]  lg:gap-[2rem] 2xl:gap-[3rem]">
        <p class="text-[1.5rem] md:text-3xl  lg:text-[2rem]  2xl:text-[3rem]">Fashionable - software as service (SaaS)</p>
        <p class="text-[1.5rem] md:text-3xl  lg:text-[2rem]  2xl:text-[3rem]">Melisa Fashion e-commerce website - DEMO</p>
        <p class="md:text-xl  lg:text-[1.5rem]  2xl:text-[1.8rem]">Fashionable softver nije vlasnik niti vrši prodaju artikala prikazanih ovdje</p>
        <p class="md:text-xl  lg:text-[1.5rem]  2xl:text-[1.8rem]">Developed by Mirza Mehagić</p>
        <p class="md:text-xl  lg:text-[1.5rem]  2xl:text-[1.8rem]">Copyright © <?php echo date("Y"); ?></p>
        <p class="md:text-xl  lg:text-[1.5rem]  2xl:text-[1.8rem]">Mirza Mehagić All rights reserved</p>
        <p class="md:text-xl  lg:text-[1.5rem]  2xl:text-[1.8rem]">Contact: mirza.mehagic@hotmail.com</p>
    </nav>
    <nav class="flex mt-[2rem] flex-row justify-center xl:col-start-1 xl:row-start-1  items-center self-end gap-[1rem]">
        <a href="https://www.facebook.com/mirza.mehagic" target="_blank"> <img class="w-[2rem] lg:w-[3rem]" src="{{ asset('storage/images/facebook.svg') }}" alt="facebook-logo" width="55" height="55" /></a>
        <a href="https://www.linkedin.com/in/mirza.mehagic" target="_blank"><img class="w-[2rem] lg:w-[3rem]" src="{{ asset('storage/images/linkedin-icon-1-logo-svg-vector.svg') }}" alt="linkedin-logo" width="55" height="65" /></a>
        <a class="self-end" href=https://github.com/MirzaDevelopment target="_blank"><img class="w-[3rem] lg:w-[4rem] xl:w-[4.5rem]" src="{{ asset('storage/images/github-2-logo-svg-vector.svg') }}" alt="github-logo" width="55" height="65" /></a>
    </nav>
</footer>