<div><!--Livewire frontend component with input fields for editing product heel category-->
    <!--Livewire components for heel-->
    <div @if ($errors->has('heelSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
        <livewire:heel-edit-render :heelSelect="$heelSelect" :heelDeSelect="$heelDeSelect" />
        @error('heelSelect')
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
        @enderror
    </div>
</div>