<div><!--Livewire frontend component with input fields for editing product material category-->

    <!--Livewire components for material-->
    <div @if ($errors->has('materialSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
        <livewire:material-edit-render :materialSelect="$materialSelect" :materialDeSelect="$materialDeSelect" />
        @error('materialSelect')
        <!-- Validation failed message -->
        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
        @enderror
    </div>
   
</div>