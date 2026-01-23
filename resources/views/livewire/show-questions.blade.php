<div>
    <div class="grid grid-cols-1 max-w-[420px] m-auto sm:grid-cols-2 sm:max-w-[100%]  lg:m-auto lg:max-w-[100%]  xl:grid-cols-3 xl:max-w-[100%] 2xl:grid-cols-4  gap-[1rem] p-5">
        @foreach($questions as $question)
        <section x-data="{ open: false }" class="flex bg-white rounded flex-col p-[2rem] gap-[1rem]">
            <span class="text-lg"><span class="underline font-medium">Od:</span> {{$question->user_name}}</span>
            <span class="text-lg"><span class="underline font-medium">Email:</span> {{$question->user_email}} </span>
            <span><span class="underline font-medium">Komentar:</span> {{$question->question}}</span>
            <span><span class="underline font-medium">Status:</span> @if($question->status=="neodgovoreno")<span class="text-[#D32F2F]"> {{$question->status}}</span>@else<span class="text-[#28a745]"> {{$question->status}}</span>@endif</span>
            <span><span class="underline font-medium">Poslano:</span> {{$question->created_at}}</span>
            <button wire:click="deleteQuestion({{$question->id}})" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:confirm="Da li stvarno želite da obrišete poruku? Poruke će biti obrisane trajno!" wire:offline.attr="disabled" type="submit">Obriši</button>
            <button wire:click="updateQuestion({{$question->id}})" class="bg-[#28a745] text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-[#218838] transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Označi kao odgovoreno</button>
            <button x-on:click="open = ! open" wire:click="" class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-sky-700 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Odgovori (pošalji mail)</button>
            <span class="fixed bottom-[8rem] lg:bottom-[10rem] right-4  bg-white text-gray-700 border border-gray-200 rounded-full shadow-lg hover:shadow-xl z-[5000] transition-all duration-300 p-2 group">
            </span>
            <span class="" x-show="open" x-transition>
                <textarea wire:model="replyArea" placeholder='Unesite vaš odgovor.' rows="6" class="w-full px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm pt-3 outline-0 transition-all"></textarea>
                <button wire:click="sendReply" class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-sky-700 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Pošalji</button>
            </span>

        </section>
        @endforeach

    </div>
    {{ $questions->links() }}
</div>