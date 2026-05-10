<!--Admin Dashboard view-->
<x-app-layout>
    <x-slot name="header"> <!--This comes from the app.blade layout in layouts folder. Its not a separated component like in front layout-->
        <h2 class="font-semibold flex gap-x-[0.5rem]  flex-row flex-wrap text-xl text-gray-800 leading-tight">
            {{ __('Poruke od korisnika') }}
            <a class="flex flex-row" href="{{ route('questions') }}" wire:navigate><img class="cursor-pointer" src="{{ asset('storage/images/message.svg') }}" alt="messages_icon" width="25" height="20"><span class="text-[#D32F2F] ml-[5px]">@if($questionsCount)({{$questionsCount}}) Novih poruka @elseif($questionsCount==0) <span class="text-[#28a745] ml-[5px]">Nemate novih poruka @endif <span></span></a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-[50rem] xl:w-3/4 lg2:w-1/2 mx-auto sm:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    {{ __("Dobrodošli") }}
                    <p>Ovdje možete vršiti administratorske funkcije nad vašim proizvodima i korisnicima.</p>
                    <p>Molimo da se po potrebi konsultujete sa vodičem dostupnim <a href="/#footer" class="underline text-cornflowerblue">ovdje</a></p></p>
                </div>
            </div>
        </div>
    </div>
    <!--Users-->
    <div class="mb-[1rem] sm:p-6 sm:mb-[0rem] max-w-[50rem] m-auto grid grid-cols-1 items-center justify-center">
        <h1 class="text-xl bg-white overflow-hidden shadow-sm p-[2rem] sm:rounded-t-lg">Korisnici ({{$usersCount}})</h1>
        <nav class="p-6 gap-4 grid grid-cols-2 md:grid-cols-3  xl:grid lg:grid-cols-3 justify-center bg-white overflow-hidden shadow-sm sm:rounded-b-lg">
            <!--Add users-->
            <div class="flex flex-col items-center">
                <a href="{{ route('adduser') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M21.97 2.33C21.25 1.51 20.18 1 19 1C17.88 1 16.86 1.46 16.13 2.21C15.71 2.64 15.39 3.16 15.2 3.74C15.07 4.14 15 4.56 15 5C15 5.75 15.21 6.46 15.58 7.06C15.78 7.4 16.04 7.71 16.34 7.97C17.04 8.61 17.97 9 19 9C19.44 9 19.86 8.93 20.25 8.79C21.17 8.5 21.94 7.87 22.42 7.06C22.63 6.72 22.79 6.33 22.88 5.93C22.96 5.63 23 5.32 23 5C23 3.98 22.61 3.04 21.97 2.33ZM20.49 5.73H19.75V6.51C19.75 6.92 19.41 7.26 19 7.26C18.59 7.26 18.25 6.92 18.25 6.51V5.73H17.51C17.1 5.73 16.76 5.39 16.76 4.98C16.76 4.57 17.1 4.23 17.51 4.23H18.25V3.52C18.25 3.11 18.59 2.77 19 2.77C19.41 2.77 19.75 3.11 19.75 3.52V4.23H20.49C20.9 4.23 21.24 4.57 21.24 4.98C21.24 5.39 20.91 5.73 20.49 5.73Z" fill="#292D32"></path>
                            <path d="M22 12C22 10.69 21.75 9.43 21.28 8.28C20.97 8.5 20.62 8.67 20.25 8.79C20.14 8.83 20.03 8.86 19.91 8.89C20.29 9.85 20.5 10.9 20.5 12C20.5 14.32 19.56 16.43 18.04 17.97C17.75 17.6 17.38 17.26 16.94 16.97C14.23 15.15 9.79 15.15 7.06 16.97C6.62 17.26 6.26 17.6 5.96 17.97C4.44 16.43 3.5 14.32 3.5 12C3.5 7.31 7.31 3.5 12 3.5C13.09 3.5 14.14 3.71 15.1 4.09C15.13 3.97 15.16 3.86 15.2 3.74C15.32 3.37 15.49 3.03 15.72 2.72C14.57 2.25 13.31 2 12 2C6.49 2 2 6.49 2 12C2 14.9 3.25 17.51 5.23 19.34C5.23 19.35 5.23 19.35 5.22 19.36C5.32 19.46 5.44 19.54 5.54 19.63C5.6 19.68 5.65 19.73 5.71 19.77C5.89 19.92 6.09 20.06 6.28 20.2C6.35 20.25 6.41 20.29 6.48 20.34C6.67 20.47 6.87 20.59 7.08 20.7C7.15 20.74 7.23 20.79 7.3 20.83C7.5 20.94 7.71 21.04 7.93 21.13C8.01 21.17 8.09 21.21 8.17 21.24C8.39 21.33 8.61 21.41 8.83 21.48C8.91 21.51 8.99 21.54 9.07 21.56C9.31 21.63 9.55 21.69 9.79 21.75C9.86 21.77 9.93 21.79 10.01 21.8C10.29 21.86 10.57 21.9 10.86 21.93C10.9 21.93 10.94 21.94 10.98 21.95C11.32 21.98 11.66 22 12 22C12.34 22 12.68 21.98 13.01 21.95C13.05 21.95 13.09 21.94 13.13 21.93C13.42 21.9 13.7 21.86 13.98 21.8C14.05 21.79 14.12 21.76 14.2 21.75C14.44 21.69 14.69 21.64 14.92 21.56C15 21.53 15.08 21.5 15.16 21.48C15.38 21.4 15.61 21.33 15.82 21.24C15.9 21.21 15.98 21.17 16.06 21.13C16.27 21.04 16.48 20.94 16.69 20.83C16.77 20.79 16.84 20.74 16.91 20.7C17.11 20.58 17.31 20.47 17.51 20.34C17.58 20.3 17.64 20.25 17.71 20.2C17.91 20.06 18.1 19.92 18.28 19.77C18.34 19.72 18.39 19.67 18.45 19.63C18.56 19.54 18.67 19.45 18.77 19.36C18.77 19.35 18.77 19.35 18.76 19.34C20.75 17.51 22 14.9 22 12Z" fill="#292D32"></path>
                            <path d="M12 6.92969C9.93 6.92969 8.25 8.60969 8.25 10.6797C8.25 12.7097 9.84 14.3597 11.95 14.4197C11.98 14.4197 12.02 14.4197 12.04 14.4197C12.06 14.4197 12.09 14.4197 12.11 14.4197C12.12 14.4197 12.13 14.4197 12.13 14.4197C14.15 14.3497 15.74 12.7097 15.75 10.6797C15.75 8.60969 14.07 6.92969 12 6.92969Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Dodaj korisnike</h3>
            </div>
            <!--Show and modify users-->
            <div class="flex flex-col items-center">
                <a href="{{ route('users') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12 2C9.24 2 7 4.24 7 7C7 9.76 9.24 12 12 12C14.76 12 17 9.76 17 7C17 4.24 14.76 2 12 2ZM14.17 6.51L11.47 9.21C11.37 9.31 11.16 9.41 11.02 9.44L9.99 9.58C9.61 9.63 9.35 9.37 9.41 9L9.56 7.97C9.58 7.83 9.68 7.62 9.79 7.52L12.49 4.82C12.95 4.36 13.5 4.14 14.18 4.82C14.85 5.51 14.63 6.05 14.17 6.51Z" fill="#292D32"></path>
                            <path d="M12.0002 14C6.99016 14 2.91016 17.36 2.91016 21.5C2.91016 21.78 3.13016 22 3.41016 22H20.5902C20.8702 22 21.0902 21.78 21.0902 21.5C21.0902 17.36 17.0102 14 12.0002 14Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Upravljaj korisnicima</h3>
            </div>
            <!--Delete users-->
            <div class="flex flex-col items-center">
                <a href="{{ route('deleted-users') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12 2C9.38 2 7.25 4.13 7.25 6.75C7.25 9.32 9.26 11.4 11.88 11.49C11.96 11.48 12.04 11.48 12.1 11.49C12.12 11.49 12.13 11.49 12.15 11.49C12.16 11.49 12.16 11.49 12.17 11.49C14.73 11.4 16.74 9.32 16.75 6.75C16.75 4.13 14.62 2 12 2Z" fill="#292D32"></path>
                            <path d="M17.0809 14.1489C14.2909 12.2889 9.74094 12.2889 6.93094 14.1489C5.66094 14.9989 4.96094 16.1489 4.96094 17.3789C4.96094 18.6089 5.66094 19.7489 6.92094 20.5889C8.32094 21.5289 10.1609 21.9989 12.0009 21.9989C13.8409 21.9989 15.6809 21.5289 17.0809 20.5889C18.3409 19.7389 19.0409 18.5989 19.0409 17.3589C19.0309 16.1289 18.3409 14.9889 17.0809 14.1489ZM13.9409 18.2589C14.2309 18.5489 14.2309 19.0289 13.9409 19.3189C13.7909 19.4689 13.6009 19.5389 13.4109 19.5389C13.2209 19.5389 13.0309 19.4689 12.8809 19.3189L12.0009 18.4389L11.1209 19.3189C10.9709 19.4689 10.7809 19.5389 10.5909 19.5389C10.4009 19.5389 10.2109 19.4689 10.0609 19.3189C9.77094 19.0289 9.77094 18.5489 10.0609 18.2589L10.9409 17.3789L10.0609 16.4989C9.77094 16.2089 9.77094 15.7289 10.0609 15.4389C10.3509 15.1489 10.8309 15.1489 11.1209 15.4389L12.0009 16.3189L12.8809 15.4389C13.1709 15.1489 13.6509 15.1489 13.9409 15.4389C14.2309 15.7289 14.2309 16.2089 13.9409 16.4989L13.0609 17.3789L13.9409 18.2589Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Obrisani korisnici ({{$deletedUsersCount}})</h3>
            </div>
        </nav>
    </div>
    <!--Products-->
    <div class="sm:p-6 max-w-[50rem] m-auto grid grid-cols-1 items-center justify-center">
        <h1 class="text-xl bg-white overflow-hidden shadow-sm p-[2rem] sm:rounded-t-lg ">Proizvodi ({{$productsCount}})</h1>
        <nav class="p-6 gap-4 grid grid-cols-2 md:grid-cols-3 xl:grid lg:grid-cols-3 justify-center bg-white overflow-hidden shadow-sm sm:rounded-b-lg">
            <!--Add Products-->
            <div class="flex flex-col items-center">
                <a href="{{ route('addproduct') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM16 12.75H12.75V16C12.75 16.41 12.41 16.75 12 16.75C11.59 16.75 11.25 16.41 11.25 16V12.75H8C7.59 12.75 7.25 12.41 7.25 12C7.25 11.59 7.59 11.25 8 11.25H11.25V8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V11.25H16C16.41 11.25 16.75 11.59 16.75 12C16.75 12.41 16.41 12.75 16 12.75Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Dodaj proizvode i zamjensku sliku</h3>
            </div>
            <!--Show and modify Products-->
            <div class="flex flex-col items-center">
                <a href="{{ route('products') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M9.93 12.75H3C2.45 12.75 2 13.2 2 13.75V16.19C2 19.4 4.6 22 7.81 22H9.51C10.28 22 10.75 21.18 10.38 20.5C9.59 19.03 9.28 17.26 9.67 15.4C9.81 14.72 10.05 14.08 10.37 13.48C10.54 13.15 10.31 12.75 9.93 12.75ZM6.75 18C6.75 18.41 6.41 18.75 6 18.75C5.59 18.75 5.25 18.41 5.25 18V16C5.25 15.59 5.59 15.25 6 15.25C6.41 15.25 6.75 15.59 6.75 16V18Z" fill="#292D32"></path>
                            <path d="M16.19 2H7.81C4.6 2 2 4.6 2 7.81V10.25C2 10.8 2.45 11.25 3 11.25H11.84C12.06 11.25 12.27 11.17 12.45 11.03C13.31 10.37 14.32 9.89 15.4 9.67C17.26 9.28 19.03 9.59 20.5 10.38C21.18 10.74 22 10.28 22 9.51V7.81C22 4.6 19.4 2 16.19 2ZM6.75 8.25C6.75 8.66 6.41 9 6 9C5.59 9 5.25 8.66 5.25 8.25V6.25C5.25 5.84 5.59 5.5 6 5.5C6.41 5.5 6.75 5.84 6.75 6.25V8.25ZM10.75 8.25C10.75 8.66 10.41 9 10 9C9.59 9 9.25 8.66 9.25 8.25V6.25C9.25 5.84 9.59 5.5 10 5.5C10.41 5.5 10.75 5.84 10.75 6.25V8.25ZM18 8H14C13.59 8 13.25 7.66 13.25 7.25C13.25 6.84 13.59 6.5 14 6.5H18C18.41 6.5 18.75 6.84 18.75 7.25C18.75 7.66 18.41 8 18 8Z" fill="#292D32"></path>
                            <path d="M17 11C13.69 11 11 13.69 11 17C11 20.31 13.69 23 17 23C20.31 23 23 20.31 23 17C23 13.69 20.31 11 17 11ZM19.93 18.2C19.77 18.59 19.54 18.94 19.24 19.24C18.64 19.84 17.85 20.17 17 20.17C16.32 20.17 15.68 19.95 15.14 19.55V19.69C15.14 20 14.89 20.26 14.57 20.26C14.25 20.25 14 20 14 19.68V18.24C14 17.93 14.25 17.67 14.57 17.67H16.01C16.32 17.67 16.58 17.92 16.58 18.24C16.58 18.53 16.37 18.75 16.09 18.79C16.85 19.16 17.82 19.04 18.43 18.43C18.62 18.24 18.77 18.01 18.87 17.76C18.99 17.47 19.32 17.33 19.61 17.45C19.91 17.57 20.05 17.91 19.93 18.2ZM20 15.76C20 16.07 19.75 16.33 19.43 16.33H17.99C17.68 16.33 17.42 16.08 17.42 15.76C17.42 15.47 17.63 15.25 17.91 15.21C17.15 14.84 16.18 14.96 15.56 15.57C15.39 15.74 15.26 15.93 15.16 16.14C15.06 16.35 14.86 16.47 14.65 16.47C14.57 16.47 14.49 16.45 14.41 16.42C14.13 16.29 14 15.95 14.14 15.66C14.3 15.33 14.51 15.03 14.76 14.77C15.36 14.17 16.15 13.84 17 13.84C17.68 13.84 18.32 14.06 18.86 14.46V14.33C18.86 14.02 19.11 13.76 19.43 13.76C19.75 13.76 20 14 20 14.32V15.76Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Upravljaj proizvodima</h3>
            </div>
            <!--Delete Products-->
            <div class="flex flex-col items-center">
                <a href="{{ route('deleted-products') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M21.0697 5.23C19.4597 5.07 17.8497 4.95 16.2297 4.86V4.85L16.0097 3.55C15.8597 2.63 15.6397 1.25 13.2997 1.25H10.6797C8.34967 1.25 8.12967 2.57 7.96967 3.54L7.75967 4.82C6.82967 4.88 5.89967 4.94 4.96967 5.03L2.92967 5.23C2.50967 5.27 2.20967 5.64 2.24967 6.05C2.28967 6.46 2.64967 6.76 3.06967 6.72L5.10967 6.52C10.3497 6 15.6297 6.2 20.9297 6.73C20.9597 6.73 20.9797 6.73 21.0097 6.73C21.3897 6.73 21.7197 6.44 21.7597 6.05C21.7897 5.64 21.4897 5.27 21.0697 5.23Z" fill="#292D32"></path>
                            <path d="M19.2297 8.14C18.9897 7.89 18.6597 7.75 18.3197 7.75H5.67975C5.33975 7.75 4.99975 7.89 4.76975 8.14C4.53975 8.39 4.40975 8.73 4.42975 9.08L5.04975 19.34C5.15975 20.86 5.29975 22.76 8.78975 22.76H15.2097C18.6997 22.76 18.8398 20.87 18.9497 19.34L19.5697 9.09C19.5897 8.73 19.4597 8.39 19.2297 8.14ZM13.6597 17.75H10.3297C9.91975 17.75 9.57975 17.41 9.57975 17C9.57975 16.59 9.91975 16.25 10.3297 16.25H13.6597C14.0697 16.25 14.4097 16.59 14.4097 17C14.4097 17.41 14.0697 17.75 13.6597 17.75ZM14.4997 13.75H9.49975C9.08975 13.75 8.74975 13.41 8.74975 13C8.74975 12.59 9.08975 12.25 9.49975 12.25H14.4997C14.9097 12.25 15.2497 12.59 15.2497 13C15.2497 13.41 14.9097 13.75 14.4997 13.75Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Obrisani proizvodi ({{$deletedProductsCount}})</h3>
            </div>
            <!--Category management-->
            <div class="flex flex-col items-center">
                <a href="{{ route('categories') }}" wire:navigate>
                    <svg viewBox="0 0 24 24" width="75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M7 8H4C2.9 8 2 7.1 2 6V4C2 2.9 2.9 2 4 2H7C8.1 2 9 2.9 9 4V6C9 7.1 8.1 8 7 8Z" fill="#292D32"></path>
                            <path d="M20.8 7H17.2C16.54 7 16 6.46 16 5.8V4.2C16 3.54 16.54 3 17.2 3H20.8C21.46 3 22 3.54 22 4.2V5.8C22 6.46 21.46 7 20.8 7Z" fill="#292D32"></path>
                            <path d="M20.8 14.5H17.2C16.54 14.5 16 13.96 16 13.3V11.7C16 11.04 16.54 10.5 17.2 10.5H20.8C21.46 10.5 22 11.04 22 11.7V13.3C22 13.96 21.46 14.5 20.8 14.5Z" fill="#292D32"></path>
                            <path opacity="0.96" d="M16 13.25C16.41 13.25 16.75 12.91 16.75 12.5C16.75 12.09 16.41 11.75 16 11.75H13.25V5.75H16C16.41 5.75 16.75 5.41 16.75 5C16.75 4.59 16.41 4.25 16 4.25H9C8.59 4.25 8.25 4.59 8.25 5C8.25 5.41 8.59 5.75 9 5.75H11.75V18C11.75 19.52 12.98 20.75 14.5 20.75H16C16.41 20.75 16.75 20.41 16.75 20C16.75 19.59 16.41 19.25 16 19.25H14.5C13.81 19.25 13.25 18.69 13.25 18V13.25H16Z" fill="#292D32"></path>
                            <path d="M20.8 22H17.2C16.54 22 16 21.46 16 20.8V19.2C16 18.54 16.54 18 17.2 18H20.8C21.46 18 22 18.54 22 19.2V20.8C22 21.46 21.46 22 20.8 22Z" fill="#292D32"></path>
                        </g>
                    </svg></a>
                <h3>Upravljaj kategorijama</h3>
            </div>
        </nav>
    </div>
    <div class="pb-12">
        <!--Footer part-->
        <x-slot:footerContent>
        <p>Fashionable - software as service (SaaS)</p>
        <p>Melisa Fashion e-commerce website - DEMO</p>
        <p>Fashionable softver nije vlasnik niti vrši prodaju artikala prikazanih ovdje</p>
        <p>Developed by Mirza Mehagić</p>
        <p>Copyright © <?php echo date("Y"); ?></p>
        <p>Mirza Mehagić All rights reserved</p>
        <p>Contact: mirza.mehagic@hotmail.com</p>
        <p> Za pravne dokumente molimo da posjetite: <a href="/#footer" class="underline">Početna stranica</a></p>
        </x-slot>
    </div>
    </div>
</x-app-layout>