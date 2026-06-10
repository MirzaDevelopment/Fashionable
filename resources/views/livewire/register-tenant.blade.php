<div>
    <x-welcome-layout>
        <section class="p-6 mt-10 place-content-evenly bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
            <h1 class="text-xl">1. Registracija Vaše online prodavnice</h1>
            <hr>
            <label class="font-medium" for="tenantName">Naziv vašeg webshopa?</label>
            <input wire:model.blur="tenantName" @if ($errors->has('tenantName')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="tenantName" placeholder="" type="text" name="tenantName" required autofocus autocomplete="name" />
            @error('tenantName')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <label class="font-medium" for="slug">URL oznaka vašeg webshopa.</label>
            <input wire:model.live="slug" id="slug" @if ($errors->has('slug')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="" type="text" name="slug"></input>
            <p class="text-xs text-gray-400">Url vaše online prodavnice će izgledati ovako: www.fashionable/{{$slug}}.com</p>
            @error('slug')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <label class="font-medium" for="slug">Valuta koju koristi vaša online prodavnica</label>
            <div x-data="{ open: false }" class="relative w-full">
                <button type="button" @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 border rounded-lg bg-white">
                    <div class="flex items-center gap-2">
                        @if($currency === 'EUR')
                        <img src="https://flagcdn.com/w20/eu.png" alt="EU" class="w-5 h-4">
                        <span>EUR - Euro</span>
                        @elseif($currency === 'BAM')
                        <img src="https://flagcdn.com/w20/ba.png" alt="BiH" class="w-5 h-4">
                        <span>BAM - Konvertibilna marka</span>
                        @elseif($currency === 'RSD')
                        <img src="https://flagcdn.com/w20/rs.png" alt="Srbija" class="w-5 h-4">
                        <span>RSD - Srpski dinar</span>
                        @endif
                    </div>

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" class="absolute z-10 w-full mt-1 bg-white border rounded-lg shadow">
                    <button type="button" wire:click="$set('currency', 'EUR')" @click="open = false" class="flex items-center w-full gap-2 px-4 py-2 hover:bg-gray-100">
                        <img src="https://flagcdn.com/w20/eu.png" alt="EU" class="w-5 h-4">
                        EUR - Euro
                    </button>

                    <button type="button" wire:click="$set('currency', 'BAM')" @click="open = false" class="flex items-center w-full gap-2 px-4 py-2 hover:bg-gray-100">
                        <img src="https://flagcdn.com/w20/ba.png" alt="BiH" class="w-5 h-4">
                        BAM - Konvertibilna marka
                    </button>

                    <button type="button" wire:click="$set('currency', 'RSD')" @click="open = false" class="flex items-center w-full gap-2 px-4 py-2 hover:bg-gray-100">
                        <img src="https://flagcdn.com/w20/rs.png" alt="Srbija" class="w-5 h-4">
                        RSD - Srpski dinar
                    </button>
                </div>
            </div>
            @error('currency')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <x-primary-button wire:click="registerTenant" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

                {{ __('Kreiraj moju online prodavnicu') }}

            </x-primary-button>
    </x-welcome-layout>
</div>