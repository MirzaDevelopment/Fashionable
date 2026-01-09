<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Obrišite račun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Kada obrišete svoj nalog, svi povezani resursi i podaci biće trajno izbrisani i neće biti moguće njihovo vraćanje. Molimo vas da pre preduzimanja ove akcije preuzmete sve informacije koje želite da sačuvate.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Obrišite račun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Da li stvarno želite da obrišete vaš račun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Kada vaš nalog bude obrisan, svi njegovi resursi i podaci bit će trajno izbrisani. Molimo unesite svoju lozinku kako biste potvrdili da želite trajno obrisati svoj nalog.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Prekid') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Obriši račun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
