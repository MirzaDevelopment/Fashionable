<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Dreams to wear">
    <title>{{ config('app.name', 'Webshop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">
    </noscript>

    <!-- Livewire styles ONLY -->
    @livewireStyles

    <!-- Vite CSS only -->
    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-slate-100">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif
        <!-- Page Content -->
        <main class="text-center">
            {{ $slot }}
        </main>
    </div>
    <footer class="flex items-center flex-col p-3.5 text-center">
        {{$footerContent}}
    </footer>
    <!-- Vite JS (deferred automatically) -->
    @vite('resources/js/app.js')

    <!-- Livewire scripts LAST -->
    @livewireScripts
</body>

</html>