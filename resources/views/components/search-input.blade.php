<!--For practice purpouse, not neccessarily needed. Used in front page product search-->
@props(['placeholder' => 'Pretraži...', 'wireModelLive'=>'search'])
<input id="seachInput" wire:model.live="{{$wireModelLive}}" placeholder="{{$placeholder}}" {{ $attributes->merge(['type' => 'text', 'class' => 'block w-fit md:w-[60vw] lg:w-[70vw] 2xl:w-[100%]  ps-10 lg:text-xl text-gray-900 border-0 border-b border-gray-200
    appearance-none
    outline-none
    focus:outline-none focus:ring-0 focus:border-gray-900 focus:bg-gray-50
    placeholder-gray-400'])}}"</input>