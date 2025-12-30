<div><!--Livewire frontend component with input fields for editing product type category-->
    <!--Livewire components for type-->
    <div @if ($errors->has('typeSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
        <livewire:type-edit-render :typeSelect="$typeSelect" :typeDeSelect="$typeDeSelect" />
        @error('typeSelect')
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
        @enderror
    </div>
</div>