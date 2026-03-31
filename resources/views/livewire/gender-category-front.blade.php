<div>
    <!--Livewire frontend components for rendering genders on first page-->
    <section class="grid grid-cols-2  mt-[0.2rem] mb-[0.2rem]">
    @foreach ($gendersAll as $gender)
    <span wire:click="$parent.GenderSelect('{{$gender->gender}}')" class="{{in_array($gender->gender, $genderSelect) ? 'text-gray-900 border-b border-gray-900 bg-gray-50 z-[5] lg:h-[auto] text-base lg:text-xl  lg:p-[2rem] xl:p-[1rem] flex items-center justify-center cursor-pointer  min-w-[100px] max-h-[60px] p-[0.5rem] hover:bg-gray-50 ' : 'border-b border-gray-200 bg-white z-[5]  lg:h-[auto] text-base lg:text-xl lg:p-[2rem]  xl:p-[1rem] flex items-center justify-center cursor-pointer bg-gray-900 min-w-[100px] max-h-[60px] p-[0.5rem] hover:bg-gray-50'}}" wire:key="{{$gender->id}}">{{$gender->gender}}</span>
    @endforeach
    </section>
</div>
