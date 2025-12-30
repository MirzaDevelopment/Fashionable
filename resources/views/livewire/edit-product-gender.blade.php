<div><!--Livewire frontend component with input fields for editing product gender category-->

        <!--Livewire components for gender-->
        <div @if ($errors->has('genderSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
            <livewire:gender-edit-render :genderSelect="$genderSelect" :genderDeSelect="$genderDeSelect" />
            @error('genderSelect')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
        </div>

</div>