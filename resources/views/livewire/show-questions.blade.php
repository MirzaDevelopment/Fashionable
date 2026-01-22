<div>
    <div class="grid grid-cols-4 gap-[1rem] p-5">
        @foreach($questions as $question)
        <section class="flex bg-white rounded flex-col p-[2rem] gap-[1rem]">
            <span class="text-lg"><span class="underline font-medium">Od:</span> {{$question->user_name}}</span>
            <span class="text-lg"><span class="underline font-medium">Email:</span> {{$question->user_email}} </span>
            <span><span class="underline font-medium">Komentar:</span> {{$question->question}}</span>
            <span><span class="underline font-medium">Status:</span> @if($question->status=="neodgovoreno")<span class="text-[#D32F2F]"> {{$question->status}}</span>@else<span class="text-[#28a745]"> {{$question->status}}</span>@endif</span>
            <span><span class="underline font-medium">Poslano:</span> {{$question->created_at}}</span>
            <button wire:click="deleteQuestion({{$question->id}})" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:confirm="Da li stvarno želite da obrišete poruku? Poruke će biti obrisane trajno!" wire:offline.attr="disabled" type="submit">Obriši</button>
            <button wire:click="updateQuestion({{$question->id}})" class="bg-[#28a745] text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-[#218838] transition-colors duration-200 disabled:opacity-5"  wire:offline.attr="disabled" type="submit">Označi kao odgovoreno</button>
            <button wire:click="answerQuestion({{$question->id}})" class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-sky-700 transition-colors duration-200 disabled:opacity-5" wire:offline.attr="disabled" type="submit">Odgovori (pošalji mail)</button>
        </section>
        @endforeach

    </div>
    {{ $questions->links() }}
</div>