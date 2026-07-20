<div> <!--Livewire frontend component rendering user questions in admin panel-->
    <div class="grid grid-cols-1 max-w-[420px] m-auto sm:grid-cols-2 sm:max-w-[100%]  lg:m-auto lg:max-w-[100%]  xl:grid-cols-3 xl:max-w-[100%] 2xl:grid-cols-4  gap-[1rem] p-5">
        @foreach($questions as $index=>$question)
        <section wire:key="{{$question->id}}" x-data="{ open: false }" class="flex bg-white rounded flex-col p-[2rem] gap-[1rem]">
            <span class="text-lg"><span class="underline font-medium">Od:</span> {{$question->user_name}}</span>
            <span class="text-lg"><span class="underline font-medium">Email:</span> {{$question->user_email}} </span>
            <span><span class="underline font-medium">Komentar:</span> {{$question->question}}</span>
            <span><span class="underline font-medium">Status:</span> @if($question->status=="neodgovoreno")<span class="text-[#D32F2F]"> {{$question->status}}</span>@else<span class="text-[#28a745]"> {{$question->status}}</span>@endif</span>
            <span><span class="underline font-medium">Poslano:</span> {{$question->created_at}}</span>
            <button wire:click="deleteQuestion({{$question->id}})" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:confirm="Da li stvarno želite da obrišete poruku? Poruke će biti obrisane trajno!" wire:offline.attr="disabled" type="submit">Obriši</button>
            <button wire:click="updateQuestion({{$question->id}})" class="bg-[#28a745] text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-[#218838] transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Označi kao odgovoreno</button>
            <button x-on:click="open = ! open" wire:click="" class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-sky-700 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Odgovori (pošalji mail)</button>
            <span  x-show="open" x-transition>
                <textarea wire:model="replyArea.{{ $index }}" placeholder='Unesite vaš odgovor.' rows="6" class="w-full px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm pt-3 outline-0 transition-all"></textarea>
                <button wire:click="sendQuestionReply({{$question->id}})" class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-sky-700 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Pošalji</button>
            </span>
            <!--Successful message-->
            @if (!empty($replySuccess[$question->id]))
            <div x-data="{ open: true }" x-show="open" x-transition x-on:click.outside="open = false" class="mt-3 rounded-md bg-[#cce5ff] text-[#004085] p-2.5">
                {{ $replySuccess[$question->id] }}
            </div>
            @endif
            @if (!empty($replyFailed[$question->id]))
            <div x-data="{ open: true }" x-show="open" x-transition x-on:click.outside="open = false" class="mt-3 rounded-md bg-[#f8d7da] text-[#721c24] p-2.5">
                {{ $replyFailed[$question->id] }}
            </div>
            @endif
        </section>
        @endforeach
   <a class="col-start-1 lg:col-span-2 lg2:col-start-1 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dashboard') }}" wire:navigate>Natrag na ploču</a>
    </div>
    {{ $questions->links() }}
</div>
