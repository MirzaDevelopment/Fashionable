<div>
    <!--Livewire frontend components for rendering product types on first page-->
    <section class="grid grid-cols-2 mt-[0.2rem] mb-[0.2rem]">
        @foreach ($typesAll as $key => $type)
        <span wire:click="$parent.TypeSelect('{{$type->type_name}}')" class="{{in_array($type->type_name, $selectedTypesContainer) ? 'bg-gray-400 border z-[5]  lg:h-[auto] lg:text-[calc(0.7rem+1vw)]  lg:p-[2rem] xl:text-[1.5rem] xl:p-[1rem] flex items-center justify-center cursor-pointer text-white min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400 transition-shadow duration-300' : 'bg-gray-900 border z-[5]  lg:h-[auto] lg:text-[calc(0.7rem+1vw)]  lg:p-[2rem] xl:text-[1.5rem] xl:p-[1rem] flex items-center justify-center cursor-pointer text-white bg-gray-900 min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400  transition-shadow duration-300'}}" wire:key="{{$type->id}}">{{$type->type_name}}</span>
        @endforeach
    </section>

</div>