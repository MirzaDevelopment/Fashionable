<div> <!--Livewire frontend component for products search -->
    <input class="shadow-sm sm:rounded-lg border-transparent mb-4" type="text" wire:model.live.debounce.300ms="search" placeholder="Pretraži..."></input>
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
                <th class="border border-slate-300 p-[1rem]">Slike</th>
                <th style="cursor: pointer" wire:click="sortProduct('product_name')" class="border border-slate-300 p-[1rem]">Naziv</th>
                <th class="border border-slate-300 p-[1rem] min-w-[300px]">Opis proizvoda</th>
                <th style="cursor: pointer" wire:click="sortProduct('price')" class="border border-slate-300 p-[1rem]">Cijena</th>
                <th style="cursor: pointer" wire:click="sortProduct('discount')" class="border border-slate-300 p-[1rem]">Popust</th>
                <th style="cursor: pointer" wire:click="sortProduct('end_date')" class="border border-slate-300 p-[1rem]">Stanje popusta</th>
                <th style="cursor: pointer" wire:click="sortProduct('total_stock')" class="border border-slate-300 p-[1rem]">Ukupan broj artikala</th>
                <th style="cursor: pointer" wire:click="sortProduct('wishlist')" class="border border-slate-300 p-[1rem]">U listi želja</th>
                <th style="cursor: pointer" wire:click="sortProduct('type_name')" class="border border-slate-300">Vrsta</th>
                <th style="cursor: pointer" wire:click="sortProduct('products.created_at')" class="border border-slate-300 p-[1rem]">Kreiran</th>
                <th colspan="2" class="border border-slate-300 p-[1rem]">Akcija</th>
            </tr>
            @isset($products)
            @foreach ($products as $product)
            <!--Rendering products from database-->
            <tr class="{{ in_array($product->id, $checkBox) ? 'bg-[#f0f8ff]' : '' }}" wire:key="{{$product->id}}" style="cursor: pointer">
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3  min-w-[300px] sm:p-6 border border-slate-300 gap-[5px] items-center flex overflow-auto">@foreach ($product->images as $images) <img class="max-h-[300px]" fetchpriority="high" loading="eager" src="{{asset('storage/'.$images->image_320x320)}}" width="320" height="200" alt="product image"> @endforeach</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300">{{ $product->product_name }}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300 ">{{ $product->description }}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300">{{$product->price}}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300">{{$product->discount}} </td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300"> @if(empty($product->end_date)) <p class="opacity-[0.25]">Nema popusta</p> @elseif($currentDate->between($product->start_date, $product->end_date))<p class="text-[#28a745] font-semibold">Aktivan</p> @elseif($currentDate->gt($product->end_date)) <p class="text-[#D32F2F] font-semibold">Istekao</p> @else <p class="text-[#fb923c] font-semibold">Uskoro</p> @endif </td>
                <td x-data="{ show: false }" class="p-3 border border-slate-300">@foreach($product->sizesVariant as $colors)@if($colors->pivot->stock_quantity<$product->bottom_stock_limit) <p class="flex justify-center"><a href="/stock-management/{{$product->id}}?route=search" wire:navigate><img @mouseenter="show = true" @mouseleave="show = false" src="{{asset('storage/images/warning.png')}}" width="20" alt="low stock warning"></a></p>
                        <p x-show="show" x-transition class="absolute mb-2 mt-2 px-2 py-1 text-sm text-white bg-gray-800 rounded shadow-lg">Količina nekog artikla je ispod dozvoljenog minimuma!</p>@break @endif @endforeach {{ $product->total_stock }}
                </td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300">{{$product->wishlist}}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 border border-slate-300">{{ $product->type->type_name }}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="p-3 min-w-[150px] border border-slate-300">{{date('d-m-Y', strtotime($product->created_at))}}</td>
                <td wire:click="RowCheckBox({{ $product->id}})" class="{{ in_array($product->id, $checkBox) ? 'text-xl p-3 sm:p-6 border border-slate-300 bg-red-600 text-white ': 'text-xl p-3 sm:p-6 border border-slate-300'}}"><button wire:click="deleteProduct" class="bg-red-700 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-800 transition-colors duration-200 disabled:opacity-5" wire:confirm="Da li stvarno želite da obrišete proizvod/e" wire:offline.attr="disabled" type="submit" @if(!in_array($product->id, $checkBox)) disabled @endif>Obriši</button></td> <!--Disabled if offline-->
                <td class="p-3 text-xl sm:p-6 border border-slate-300 bg-sky-500 text-white">
                    <a class="bg-sky-600 text-white font-medium px-5 py-2.5 rounded-lg hover:bg-sky-700 transition-colors duration-200 shadow-sm" href="/edit-products/{{$product->id}}" wire:navigate>Izmijeni</a>
                </td> <!--Disabled if offline-->
            </tr>
            @endforeach
            @endisset
        </table>
        <!--Clear selected back and pagination links-->
        {{ $products->links() }}
        <div class="shadow-sm sm:rounded-lg border-transparent w-fit p-2 mb-4 mt-4 hover:bg-slate-100">
            <button wire:click="clearCheckbox">Očisti odabrano</button>
        </div>
        <a class="mb-6 md:mb-0 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-fit" href="{{ route('dashboard') }}" wire:navigate>Natrag na ploču</a>
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