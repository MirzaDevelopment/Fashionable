<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dreams to wear">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preload" as="image" href="/storage/images/logo-no-background.svg" type="image/webp" />
    <title>{{ config('app.name', 'Webshop') }}</title>
    <!-- Fonts -->
    <!-- Livewire styles ONLY (small, safe) -->
    @livewireStyles
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">
    </noscript>

    <!-- Critical CSS -->
    <style>
        body {
            font-family: Figtree, system-ui, sans-serif;
        }
    </style>


    <!-- Vite CSS only -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased max-w-[1920px] m-auto">
    <!-- Page header component -->
    <x-header />
    <!-- Page Content -->
    <main class="text-center">
        {{ $slot }}
    </main>
    <!-- Page footer component -->
    <x-footer />
    <!-- Livewire scripts LAST -->
    @livewireScripts
</body>

</html>