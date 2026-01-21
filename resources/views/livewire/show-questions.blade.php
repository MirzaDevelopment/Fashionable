<div>
    <div class="grid grid-cols-4 gap-[1rem] p-5">
        @foreach($questions as $question)
        <section class="flex bg-white rounded flex-col p-[2rem] gap-[1rem]">
            <span class="text-lg"><span class="underline font-medium">Od:</span>  {{$question->user_name}}</span>
            <span class="text-lg"><span class="underline font-medium">Email:</span> {{$question->user_email}} </span>
            <span><span class="underline font-medium">Komentar:</span> {{$question->question}}</span>
            <span><span class="underline font-medium">Status:</span> <span class="text-[#D32F2F]"> {{$question->status}}</span></span>
            <span><span class="underline font-medium">Poslano:</span> {{$question->created_at}}</span>
        </section>
        @endforeach

    </div>
    {{ $questions->links() }}
</div>