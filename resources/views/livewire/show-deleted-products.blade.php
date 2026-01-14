
    <div> <!--Livewire frontend component for deleted products search (soft-delete)-->
        <input class="shadow-sm sm:rounded-lg border-transparent mb-4" type="text" wire:model.live="search" placeholder="Pretraži..."></input>
        @error('name') <span class="error">{{ $message }}</span> @enderror
        <section class="pt-10 max-w-[1920px] flex flex-col bg-white overflow-auto shadow-sm sm:rounded-lg sm:p-12 m-auto w-full flex justify-center">
            <div class="relative -top-10">
                @if($count>=2)
                <!--Showing number of selected items-->
                <div class="text-[#ed143d] absolute w-fit p-2">Odabrano: {{$count}}</div>
                @endif
            </div>
            <table class="table-auto md:table-fixed border-collapse border border-slate-400 mb-1  sm:rounded-lg text-center">
                <tr class="bg-slate-100">
                    <th class="border border-slate-300 p-[1rem]">Slike proizvoda</th>
                    <th style="cursor: pointer" wire:click="sortProduct('product_name')" class="border border-slate-300 p-[1rem]">Naziv</th>
                    <th class="border border-slate-300 p-[1rem] min-w-[500px]">Opis</th>
                    <th style="cursor: pointer" wire:click="sortProduct('price')" class="border border-slate-300 p-[1rem]">Price</th>
                    <th style="cursor: pointer" wire:click="sortProduct('discount')" class="border border-slate-300 p-[1rem]">Popust</th>
                    <th style="cursor: pointer" wire:click="sortProduct('end_date')" class="border border-slate-300 p-[1rem]">Status popusta</th>
                    <th style="cursor: pointer" wire:click="sortProduct('stock')" class="border border-slate-300 p-[1rem]">Količina</th>
                    <th style="cursor: pointer" wire:click="sortProduct('type_name')" class="border border-slate-300">Vrsta</th>
                    <th style="cursor: pointer" wire:click="sortProduct('products.created_at')" class="border border-slate-300 p-[1rem]">Obrisano</th>
                    <th colspan="2" class="border border-slate-300 p-[1rem]">Akcija</th>
                </tr>
                @isset($products)
                @foreach ($products as $product)
                <!--Rendering products from database-->
                <tr wire:click="RowCheckBox({{ $product->id}})" class="{{ in_array($product->id, $checkBox) ? 'bg-[#f0f8ff]' : '' }}" wire:key="{{$product->id}}" style="cursor: pointer">
                    <td class="p-3 min-w-[200px] sm:p-6 border border-slate-300 gap-[5px] flex overflow-auto">@foreach ($product->images as $images) <img src="{{asset('storage/'.$images->image_200x200)}}" width=200 alt="product image"> @endforeach</td>
                    <td class="p-3 border border-slate-300">{{ $product->product_name }}</td>
                    <td class="p-3 border border-slate-300">{{ $product->description }}</td>
                    <td class="p-3 border border-slate-300">{{$product->price}}</td>
                    <td class="p-3 border border-slate-300">{{$product->discount}} </td>
                    <td class="p-3 border border-slate-300"> @if($currentDate->gt($product->end_date)) <p class="text-[#D32F2F] font-semibold">Expired</p> @elseif(empty($product->end_date)) <p class="opacity-[0.25]">No discount</p> @elseif($currentDate->lt($product->end_date))<p class="text-[#28a745] font-semibold">Active</p> @endif </td>
                    <td class="p-3 border border-slate-300">{{ $product->total_stock }}</td>
                    <td class="p-3 border border-slate-300">{{ $product->type->type_name }}</td>
                    <td class="p-3 min-w-[150px] border border-slate-300">{{date('d-m-Y', strtotime($product->deleted_at))}}</td>
                    <td class="{{ in_array($product->id, $checkBox) ? 'p-3 sm:p-6 border border-slate-300 bg-red-600 text-white ': 'p-3 sm:p-6 border border-slate-300'}}"><button wire:click="restoreProduct" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5 disabled:opacity-25" wire:confirm="Are you sure you want to restore selected product/s?" wire:offline.attr="disabled" type="submit" @if(!in_array($product->id, $checkBox)) disabled @endif>Vrati</button></td> <!--Disabled if offline-->
                </tr>
                </input>
                @endforeach
                @endisset
            </table>
            <!--Clear selected back and pagination links-->
            {{ $products->links() }}
            <div class="shadow-sm sm:rounded-lg border-transparent w-fit p-2 mb-4 mt-4 hover:bg-slate-100">
                <button wire:click="clearCheckbox">Očisti odabrano</button>
            </div>
            <a class="ms-4 mb-6 md:mb-0 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-fit" href="{{ route('dashboard') }}" wire:navigate>Natrag</a>
        </section>
        <!--Rendering message if no products are found-->
        @if(count($products)==0)
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