<div class="grid col-span-2"><!--Livewire frontend component with input fields for editing product tag category-->
    <!--Livewire components for tag-->
    <div @if ($errors->has('tagSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
        <livewire:tag-edit-render :tagSelect="$tagSelect" :tagDeSelect="$tagDeSelect" />
        @error('tagSelect')
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
        @enderror
    </div>  
</div>