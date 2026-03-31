<div>
    <!--Livewire frontend components for rendering product tags on first page-->
    <section class="grid grid-cols-2  mt-[0.2rem] mb-[0.2rem]">
        @foreach ($tagsAll as $tag)
        <span wire:click="$parent.TagSelect('{{$tag->tag}}')" class="{{in_array($tag->tag, $tagSelect)? ' border-b text-gray-900 border-gray-900 bg-gray-50 z-[5] lg:h-[auto] text-base lg:text-xl  lg:p-[2rem] xl:p-[1rem] flex items-center justify-center cursor-pointer  min-w-[100px] max-h-[60px] p-[0.5rem] hover:bg-gray-50 ' : 'border-b border-gray-200 bg-white z-[5]  lg:h-[auto] text-base lg:text-xl lg:p-[2rem]  xl:p-[1rem] flex items-center justify-center cursor-pointer bg-gray-900 min-w-[100px] max-h-[60px] p-[0.5rem] hover:bg-gray-50'}}" wire:key="{{$tag->id}}">{{$tag->tag}}</span>
        @endforeach
    </section>
</div>