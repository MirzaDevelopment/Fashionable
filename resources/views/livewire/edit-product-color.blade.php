<div><!--Livewire frontend component with input fields for editing product color category-->
        <!--Livewire components for color-->
        <div @if ($errors->has('colorSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
            <livewire:color-edit-render :colorSelect="$colorSelect" :colorDeSelect="$colorDeSelect" />
            @error('colorSelect')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
        </div>
         
</div>