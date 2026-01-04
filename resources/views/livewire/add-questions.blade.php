<div>
    <div class="p-4 w-[300px] mx-auto  bg-white shadow-lg max-w-[300px]">
        <h2 class="text-3xl text-slate-900 font-bold">Contact us</h2>
        <form class="mt-8 space-y-5">
            <div>
                <label class='text-sm text-slate-900 font-medium mb-2 block'>Name</label>
                <input wire:model="userName" type='text' placeholder='Enter Name' class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
            </div>
            @error('userName')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <div>
                <label class='text-sm text-slate-900 font-medium mb-2 block'>Email</label>
                <input wire:model="email" type='email' placeholder='Enter Email' class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />

            </div>
            @error('email')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <div>
                <label class='text-sm text-slate-900 font-medium mb-2 block'>Message</label>
                <textarea wire:model="question" placeholder='Enter Message' rows="6" class="w-full px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm pt-3 outline-0 transition-all"></textarea>

            </div>
            @error('question')
            <!-- Validation failed message -->
            <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
            @enderror
            <button type='button' wire:click="uploadQuestion" class="text-white bg-slate-900 font-medium hover:bg-slate-800 tracking-wide text-sm px-4 py-2.5 w-full border-0 outline-0 cursor-pointer">Send message</button>

        </form>
        @if (session('status'))
        <!-- Successful insert message -->
        <div class="lg:col-span-2 lg2:col-span-1 lg2:col-start-4 lg:col-start-3 lg:row-start-3 row-start-2" x-data="{open:true}">
            <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
        </div>
        @elseif(session('errorException'))
        <!-- Failed insert message -->
        <div class="lg:col-span-2 lg2:col-span-1 lg2:col-start-4 lg:col-start-3 lg:row-start-3 row-start-2" x-data="{open:true}">
            <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
        </div>
        @endif
    </div>
</div>