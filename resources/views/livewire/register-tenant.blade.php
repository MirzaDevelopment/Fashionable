<div> <!-- Frontend livewire component for tenant registration -->
    <x-welcome-layout>
        <section class="p-6 mt-10 place-content-evenly bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
            <h1 class="text-xl">Kreirajte svoju prodavnicu</h1>
            <hr>
            <!-- Webshop data -->
            <h2 class="text-xl">Osnovne informacije</h2>
            <!-- Webshop title -->
            <label class="font-medium" for="tenantName">Naziv</label>
            <input wire:model.blur="tenantName" @if ($errors->has('tenantName')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="tenantName" placeholder="" type="text" name="tenantName" required autofocus autocomplete="name" />
            @error('tenantName')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Webshop URL-->
            <label class="font-medium" for="slug">URL oznaka</label>
            <input wire:model.live="slug" id="slug" @if ($errors->has('slug')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="" type="text" name="slug"></input>
            <p class="text-xs text-gray-400">Url vaše online prodavnice će izgledati ovako: www.fashionable/{{$slug}}.com</p>
            @error('slug')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Webshop currency -->
            <label class="font-medium" for="slug">Valuta koju koristi vaša prodavnica</label>
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
            <!-- Webshop logo and cover image -->
            <label class="font-medium" for="logoImage">Logo koji će koristiti vaša prodavnica</label>
            <p class="text-xs">Napomena: Logo i naslovna slika (cover image) nisu obavezne kod registracije i mogu se dodati naknadno</p>
            <div class="overflow-scroll lg2:overflow-auto flex flex-col gap-6">
                <p class="text-xs text-gray-400">*Ekstenzije PNG, JPG, SVG, WEBP su dozvoljene.<br> Program automatski optimizira slike i slaže ih u odgovarajuće veličine. Nije potrebna prethodna optimizacija od strane korisnika.</p>
                <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <input wire:model="logoImage" @if ($errors->has
                    ('logoImage')) class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded border border-[#D32F2F] w-4/5 sm:w-fit 2xl:w-4/5" @endif class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded" accept="image/jpeg, image/png, image/svg, image/webp" type="file" id="logoImage"></input>

                    <!-- Progress Bar -->
                    <div x-show="uploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
                @error('logoImage')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                @if ($logoImage)
                @if (!$errors->has
                ('logoImage'))
                <div class="ml-auto mr-auto">
                    <p>Pregled slike</p>
                    <img src="{{ $logoImage->temporaryUrl()}}" width="200" />
                </div>
                @endif
                @endif
            </div>
            <label class="font-medium" for="logoImage">Naslovna slika koju će koristiti vaša prodavnica</label>
            <div class="overflow-scroll lg2:overflow-auto flex flex-col gap-6">
                <p class="text-xs text-gray-400">*Ekstenzije PNG, JPEG, JPG, WEBP su dozvoljene.<br> Program automatski optimizira slike i slaže ih u odgovarajuće veličine. Nije potrebna prethodna optimizacija od strane korisnika.</p>
                <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <input wire:model="coverImage" @if ($errors->has
                    ('coverImage')) class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded border border-[#D32F2F] w-4/5 sm:w-fit 2xl:w-4/5" @endif class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded" accept="image/jpeg, image/jpg, image/png, image/webp" type="file" id="logoImage"></input>

                    <!-- Progress Bar -->
                    <div x-show="uploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
                @error('coverImage')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                @if ($coverImage)
                @if (!$errors->has
                ('coverImage'))
                <div class="ml-auto mr-auto">
                    <p>Pregled slike</p>
                    <img src="{{ $coverImage->temporaryUrl()}}" width="200" />
                </div>
                @endif
                @endif
            </div>
            <!-- Phone number -->
            <label class="font-medium" for="phone">Vaš telefon (molimo da unesete validan telefonski broj)</label>
            <input wire:model="phone" id="phone" placeholder="format: +387 61 123 456" @if ($errors->has('phone')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="tel" name="phone"></input>
            @error('phone')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <p class="text-xs text-gray-400">Napomena: vaš broj telefona koristi se isključivo za potrebe registracije i verifikacije online prodavnice. Broj neće biti dijeljen s trećim stranama niti korišten u marketinške svrhe bez vaše saglasnosti. Podaci se obrađuju i čuvaju u skladu s važećim pravilima zaštite privatnosti.</p>
            <label class="font-medium" for="shippingProvider">Odaberite ili dopišite dostavljača sa kojim surađujete</label>
            <select wire:model="shippingProvider" class="form-select">
                <option value="">Izaberi dostavljača</option>
                <!-- Bosnia -->
                <option value="bh_posta">BH Pošta</option>
                <option value="posta_rs">Pošta Srpske</option>
                <option value="express_one">Express One BiH</option>
                <option value="dhl_bih">DHL BiH</option>
                <option value="gls_bih">GLS BiH</option>

                <!-- Croatia -->
                <option value="posta_hr">Hrvatska Pošta</option>
                <option value="dpd_hr">DPD Hrvatska</option>
                <option value="gls_hr">GLS Hrvatska</option>
                <option value="overseas_hr">Overseas Express</option>

                <!-- Serbia -->
                <option value="posta_rs_srb">Pošta Srbije</option>
                <option value="dexpress">D Express</option>
                <option value="aks">AKS</option>

                <!-- Montenegro -->
                <option value="posta_cg">Pošta Crne Gore</option>

                <!-- Other (user typed) -->
                <option value="other">Ostalo</option>
            </select>
            @if($shippingProvider === 'other')
            <input type="text" @if ($errors->has('shippingProviderOther')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="shippingProviderOther" class="form-input mt-2" placeholder="Upiši dostavljača">
            @endif
            @error('shippingProviderOther')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Courier costs -->
            <label class="font-medium" for="shippingCost">Procjenjeni troškovi dostave (može se dodati kasnije)</label>
            <input wire:model="shippingCost" id="shippingCost" @if ($errors->has('shippingCost')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="" type="number" name="shippingCost" min="0" step="0.01"></input>
            @error('shippingCost')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Shipping value threshold for free delivery -->
            <label class="font-medium" for="freeShippingThreshold">Iznos vrijednosti kupovine iznad kojeg nema troškova dostave (može se dodati kasnije)</label>
            <input wire:model="freeShippingThresholdt" id="freeShippingThreshold" @if ($errors->has('freeShippingThreshold')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="" type="number" name="freeShippingThreshold" min="0" step="0.01"></input>
            @error('freeShippingThreshold')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <!-- Tenant admin data -->
            <h2 class="text-xl">Vaš račun</h2>

            <x-primary-button wire:click="registerTenant" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

                {{ __('Kreiraj moju online prodavnicu') }}

            </x-primary-button>
    </x-welcome-layout>
</div>