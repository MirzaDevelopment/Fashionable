<!--For practice purpouse, not neccessarily needed. Used in front page product search-->
@props(['placeholder' => 'Pretraži...', 'wireModelLive'=>'search'])
<input id="seachInput" wire:model.live="{{$wireModelLive}}" placeholder= "{{$placeholder}}" {{ $attributes->merge(['type' => 'text', 'class' => 'block w-fit md:w-[60vw] lg:w-[70vw] 2xl:w-[100%]  ps-10 lg:text-xl text-gray-900 border border-gray-900 rounded-lg bg-gray-50 focus:ring-gray-800 focus:border-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'])}}"</input>

