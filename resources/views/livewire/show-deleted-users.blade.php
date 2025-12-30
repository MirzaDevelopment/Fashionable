<div><!--Livewire frontend component for deleted users search (soft-delete)-->
    <input class="shadow-sm sm:rounded-lg border-transparent mb-4" type="text" wire:model.live="search" placeholder="Search..."></input>
    @error('name') <span class="error">{{ $message }}</span> @enderror
    <section class="pt-10 max-w-[1920px] flex flex-col bg-white overflow-auto shadow-sm sm:rounded-lg sm:p-12 m-auto w-full flex justify-center">
        <div class="relative -top-10">
            @if($count>=2) 
             <!--Showing number of selected items-->
            <div class="text-[#ed143d] absolute w-fit p-2">Selected: {{$count}}</div>
            @endif
        </div>
        <table class="table-auto md:table-fixed border-collapse border border-slate-400 mb-1  sm:rounded-lg text-center">
            <tr class="bg-slate-100">
                <th class="border border-slate-300">User name</th>
                <th class="border border-slate-300">Email</th>
                <th class="border border-slate-300">Role</th>
                <th class="border border-slate-300">Deleted at</th>
                <th colspan="2" class="border border-slate-300">Action</th>
            </tr>
            @isset($users)
            @foreach ($users as $user)
             <!--Rendering deleted products from database (soft deleted)-->
            <tr wire:click="RowCheckBox({{ $user->id}})" class="{{ in_array($user->id, $checkBox) ? 'bg-[#f0f8ff]' : '' }}" wire:key="{{$user->id}}" style="cursor: pointer">
                <td class="p-3 sm:p-6 border border-slate-300">{{ $user->name }}</td>
                <td class="p-3 sm:p-6 border border-slate-300">{{ $user->email }}</td>
                <td class="p-3 sm:p-6 border border-slate-300">{{ $user->role }}</td>
                <td class="p-3 sm:p-6 border border-slate-300">{{$user->deleted_at}}</td>
                <td class="{{ in_array($user->id, $checkBox) ? 'p-3 sm:p-6 border border-slate-300 bg-red-600 text-white ': 'p-3 sm:p-6 border border-slate-300'}}"><button wire:click="restoreUser" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:confirm="Are you sure you want to restore selected user/s?" wire:offline.attr="disabled" type="submit" @if(!in_array($user->id, $checkBox)) disabled @endif>Restore</button></td> <!--Disabled if offline-->
            </tr>
            </input>
            @endforeach
            @endisset
        </table>
        <!--Clear selected back and pagination links-->
        {{ $users->links() }}
        <div class="shadow-sm sm:rounded-lg border-transparent w-fit p-2 mb-4 hover:bg-slate-100">
            <button wire:click="clearCheckbox">Clear selected</button>
        </div>
        <a class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-fit" href="{{ route('dashboard') }}" wire:navigate>Back</a>
    </section>
    <!--Rendering message if no users are found-->
    @if(count($users)==0)
    {{$empty}}
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    @endif
</div>