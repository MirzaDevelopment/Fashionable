<div><!--Livewire frontend component with input fields for editing product size category-->
    <!--Livewire components for size-->
    <div @if ($errors->has('sizeSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
        <livewire:size-edit-render :sizeSelect="$sizeSelect" :sizeDeSelect="$sizeDeSelect" />
        @error('sizeSelect')
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
        @enderror
    </div>

    
</div>