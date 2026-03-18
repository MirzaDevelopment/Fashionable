<div>
    <!--Livewire frontend components for rendering product tags on first page-->
    <section class="grid grid-cols-2  mt-[0.2rem] mb-[0.2rem]">
        @foreach ($tagsAll as $tag)
        <span wire:click="$parent.TagSelect('{{$tag->tag}}')" class="{{in_array($tag->tag, $tagSelect)? 'bg-gray-400 z-[5] rounded-lg border break-words lg:h-[auto] lg:text-[calc(0.7rem+1vw)] xl:text-[1.5rem] xl:p-[1rem] lg:p-[2rem] flex items-center justify-center cursor-pointer text-white min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400 transition-shadow duration-300' : 'bg-gray-900 rounded-lg z-[5] border lg:h-[auto] lg:text-[calc(0.7rem+1vw)]  break-words lg:p-[2rem] xl:text-[1.5rem] xl:p-[1rem]  flex items-center justify-center cursor-pointer text-white bg-gray-900 min-w-[100px] max-h-[60px] p-[0.5rem] shadow-md hover:bg-gray-400  transition-shadow duration-300'}}" wire:key="{{$tag->id}}">{{$tag->tag}}</span>
        @endforeach
    </section>
</div>