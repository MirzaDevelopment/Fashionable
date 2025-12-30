<div>
    <!--Livewire frontend components for rendering genders on first page-->
    <section class="grid grid-cols-2  mt-[0.2rem] mb-[0.2rem]">
    @foreach ($gendersAll as $gender)
    <span wire:click="$parent.GenderSelect('{{$gender->gender}}')" class="{{in_array($gender->gender, $genderSelect) ? 'bg-gray-400 z-[5] border lg:h-[auto] lg:text-[calc(0.7rem+1vw)]  lg:p-[2rem] xl:text-[1.5rem] xl:p-[1rem] flex items-center justify-center cursor-pointer text-white min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400 transition-shadow duration-300' : 'bg-gray-900  z-[5] border lg:h-[auto] lg:text-[calc(0.7rem+1vw)]  lg:p-[2rem] xl:text-[1.5rem] xl:p-[1rem] flex items-center justify-center cursor-pointer text-white bg-gray-900 min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400  transition-shadow duration-300'}}" wire:key="{{$gender->id}}">{{$gender->gender}}</span>
    @endforeach
    </section>
</div>
