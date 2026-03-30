<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dreams to wear">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preload" as="image" href="/storage/images/melisa_fashion_logo_header.svg" type="image/webp" />
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
      <!-- Your page content -->

    <!-- Place cookie consent script at the end of body -->
    <script type="text/javascript" src="https://www.termsfeed.com/public/cookie-consent/4.2.0/cookie-consent.js" charset="UTF-8" async></script>
    <script type="text/javascript" charset="UTF-8">
        document.addEventListener('DOMContentLoaded', function () {
            cookieconsent.run({
                "notice_banner_type":"simple",
                "consent_type":"express",
                "palette":"light",
                "language":"hr",
                "page_load_consent_levels":["strictly-necessary"],
                "notice_banner_reject_button_hide":false,
                "preferences_center_close_button_hide":false,
                "page_refresh_confirmation_buttons":false,
                "website_name":"Fashionable"
            });
        });
    </script>
        <!-- Message for users with JavaScript disabled -->
    <noscript>
        Free cookie consent management tool by <a href="https://www.termsfeed.com/">TermsFeed Generator</a>
    </noscript>
    <a href="#" id="open_preferences_center">Update cookies preferences</a>
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