<div>
    <!--Livewire frontend component - view with input fields for adding products-->
    <div @if($lightBox) class="mt-10 bg-white static flex justify-center lg2:items-center items-end" @endif class="mt-10 bg-white">
        <div @if($lightBox) class="sm:grid grid-cols-2 gap-x-2 lg:grid-cols-4 gap-y-6 w-full px-6 py-4 bg-white overflow-hidden sm:rounded-lg m-auto bg-gray-800 blur-lg" @endif class="sm:grid grid-cols-2 gap-x-2 lg:grid-cols-4 gap-y-6 w-full px-6 py-4 bg-white overflow-hidden sm:rounded-lg m-auto">
            <!--Product general info section-->
            <section class="p-6 mt-10 place-content-evenly bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                <h2 class="text-xl">1. Product general info</h2>
                <hr>
                <label class="font-medium" for="productName">What's your product name?</label>
                <input wire:model.blur="productName" @if ($errors->has('productName')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="productName" placeholder="Cosy brown winter boots" type="text" name="productName" required autofocus autocomplete="name" />
                @error('productName')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                <label class="font-medium" for="productDescription">Describe your product.</label>
                <textarea wire:model.blur="productDescription" id="productDescription" @if ($errors->has('productDescription')) class="border-[#D32F2F]" @endif class="min-h-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Perfect for winter walks, shopping trips, or casual outings—these Cosy Brown Winter Boots will become your go-to footwear all season long."></textarea>
                @error('productDescription')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
            </section>
            <!--Prices and discount section-->
            <section class="p-6 mt-10 bg-white place-content-evenly border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                <h2 class="text-xl">2. Product prices and discounts</h2>
                <hr>
                <label class="font-medium" for="productPrice">Set your starting product price.</label>
                <input wire:model.blur="productPrice" id="productPrice" type="number" min="0" @if ($errors->has('productPrice')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Starting price">
                @error('productPrice')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                <label class="font-medium" for="productDiscount">Set your starting discount or leave it empty.</label>
                <input wire:model.live="productDiscount" id="productDiscount" type="number" min="0" @if ($errors->has('productDiscount')) class="border-[#D32F2F]" @endif class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Discount precentage">
                @error('productDiscount')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                <label class="font-medium" for="productDiscount">Set the starting and end date for your discount.</label>
                <input wire:model.blur="startDate" @if(empty($productDiscount)) class="opacity-[.25]" disabled @endif type="date" @if ($errors->has('startDate')) class="border-[#D32F2F]" @endif id="startDate" name="startDate" value="" min="2018-01-01" />
                @error('startDate')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                @if (session('errorDates'))
                <div class="text-[#D32F2F] mt-2">
                    {{ session('errorDates') }}
                </div>
                @endif
                <input wire:model.blur="endDate" @if(empty($productDiscount)) class="opacity-[.25]" disabled @endif type="date" @if ($errors->has('endDateName')) class="border-[#D32F2F]" @endif id="endDate" name="endDate" value="" min="2018-01-01" />
                @error('endDate')
                <!-- Validation failed message -->
                <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                @enderror
                <!-- Empty dates if discount is selected message -->
                @if (session('errorDates'))
                <div class="text-[#D32F2F] mt-2">
                    {{ session('errorDates') }}
                </div>
                @endif
            </section>
            <!--Select product categories section-->
            <section class="p-6 mt-10 max-h-[845px] sm:col-span-2 lg2:col-span-1 bg-white sm:grid-cols-subgrid gap-4  border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
                <h2 class="text-xl">3. Product categories and tags</h2>
                <hr>
                <p class="font-medium">Choose your product category and tag.</p>
                <div class="overflow-scroll lg2:overflow-auto sm:grid grid-cols-2 gap-6 w-full bg-white overflow-hidden">
                    <!--Livewire components for material, heel, color, gender, tags, size and product type-->
                    <div @if ($errors->has('materialSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:material-render :materialSelect="$materialSelect" />
                        @error('materialSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div @if ($errors->has('typeSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:type-render :typeSelect="$typeSelect" />
                        @error('typeSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                        <!-- Selecting more than one product type error message -->
                        @if (session('errorType'))
                        <div class="text-[#D32F2F] mt-2">
                            {{ session('errorType') }}
                        </div>
                        @endif
                    </div>
                    <div @if ($errors->has('heelSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:heel-render :heelSelect="$heelSelect" />
                        <!-- Selecting more than one heel type error message -->
                        @if (session('errorHeel'))
                        <div class="text-[#D32F2F] mt-2">
                            {{ session('errorHeel') }}
                        </div>
                        @endif
                    </div>
                    <div @if ($errors->has('colorSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:color-render :colorSelect="$colorSelect" />
                        @error('colorSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div @if ($errors->has('genderSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:gender-render :genderSelect="$genderSelect" />
                        @error('genderSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div @if ($errors->has('sizeSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10">
                        <livewire:size-render :sizeSelect="$sizeSelect" />
                        @error('sizeSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div @if ($errors->has('tagSelect')) class="p-2 border border-[#D32F2F]" @endif class="mb-10 col-span-2">
                        <livewire:tag-render :tagSelect="$tagSelect" />
                        @error('tagSelect')
                        <!-- Validation failed message -->
                        <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>
            <!--Upload product images section-->
            <section class="p-6 mt-10 max-h-[845px] sm:col-span-2 lg2:col-span-1 sm:grid-cols-subgrid gap-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-6">
                <h2 class="text-xl">4. Product images</h2>
                <hr>
                <label class="font-medium" for="productImage">Upload your product image for each color.</label>
                <div class="overflow-scroll lg2:overflow-auto flex flex-col gap-6">
                    <p class="text-xs text-gray-400">PNG, JPG SVG, WEBP, and GIF are Allowed.</p>
                    <!--Input fields for colors-->
                    @isset($colorSelect)
                    @foreach ($colorSelect as $index => $color)
                    <p class="font-bold"> Upload your {{$color}} {{ implode(', ', $typeSelect) }} image </p>
                    <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <input wire:model="productImage.{{ $index }}" wire:key="{{$index}}" @if ($errors->has
                        ('productImage.'.$index)) class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded border border-[#D32F2F] w-4/5 sm:w-fit 2xl:w-4/5" @endif class="w-full text-gray-500 font-medium text-base bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded" accept="image/jpeg, image/png, image/webp" type="file" id="productImage"></input>

                        <!-- Progress Bar -->
                        <div x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    @error('productImage.'. $index)
                    <!-- Validation failed message -->
                    <span class="error text-[#D32F2F] mt-1">{{ $message }}</span>
                    @enderror
                    @endforeach
                    @if ($productImage)
                    @foreach ($productImage as $index => $imageField)
                    @if (!$errors->has
                    ('productImage.'.$index))
                    <div class="ml-auto mr-auto">
                        <p>Image preview</p>
                        <img wire:key="{{$index}}" src="{{ $imageField->temporaryUrl()}}" width="200" />
                    </div>
                    @endif
                    @endforeach
                    @endif
                    @endisset
                </div>
            </section>
            <!--Back and submit product buttons section-->
            <section class="mt-10 grid grid-cols-subgrid gap-4 col-span-2 lg:col-span-4 lg2:col-span-4">
                <a class="col-start-1 lg:col-span-2 lg2:col-start-1 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dashboard') }}" wire:navigate>Back to Dashboard</a>
                <x-primary-button wire:click="uploadProduct" wire:offline.attr="disabled" wire:loading.attr="disabled" wire:loading.class="opacity-50" class="lg:col-span-2 justify-center col-start-2 lg2:col-start-4">

                    {{ __('Submit product') }}

                </x-primary-button>
                @if (session('status'))
                <!-- Moving towards stock management -->
                <a class="col-start-1 lg:col-span-2 lg:col-start-3 bg-sky-500 lg2:col-start-4 row-start-3 lg:row-start-4 lg2:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="/stock-management/{{$productId}}" wire:navigate>Update product stocks</a>

                @endif
                <!--Livewire components for default image upload-->
                <livewire:add-default-image />
                <span class="text-xs text-gray-400 md:col-span-1 lg:col-span-2 lg2:col-span-1 col-span-2">*Upload a placeholder image to use when no other image is available. This option is only for modifying or adding new product colors that don't have an associated image yet.</span>
                <!-- Reloading page button with js -->
                <x-primary-button onclick="location.reload();" class="justify-center row-start-2 xl:col-span-2 xl:col-start-3 col-start-2 lg:col-start-3 lg:col-span-2 lg2:col-span-1 lg2:col-start-4">
                    {{ __('Clear all') }}
                </x-primary-button>
                @if (session('status'))
                <!-- Successful insert message -->
                <div class="lg:col-span-2 lg2:col-span-1 lg2:col-start-4 lg:col-start-3 lg:row-start-3 row-start-2" x-data="{open:true}">
                    <div class="text-[#004085] rounded-md p-2.5 bg-[#cce5ff] justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('status')}}</div>
                </div>
                <!-- Resetting input -->
                <x-primary-button wire:click="resetProduct" class="justify-center mt-2 xl:col-span-2 xl:col-start-3 lg:col-start-3 row-start-3 lg:row-start-5 md:col-start-5 lg:col-span-2 lg2:col-span-1 lg2:col-start-4">
                    {{ __('Clear input fields') }}
                </x-primary-button>
                @elseif(session('errorException'))
                <!-- Failed insert message -->
                <div class="lg:col-span-2 lg2:col-span-1 lg2:col-start-4 lg:col-start-3 lg:row-start-3 row-start-2" x-data="{open:true}">
                    <div class="text-[#721c24] rounded-md bg-[#f8d7da] p-2.5 justify-center" x-show="open" x-on:click.outside="open=false" x-transition>{{ session('errorException')}}</div>
                </div>
                @endif
            </section>
        </div>
        <!-- Product preview -->
        <section @if($lightBox) class="mt-10 rounded-lg absolute p-4 lg2:max-h-screen xl:max-h-screen overflow-scroll mb-10 lg2:w-1/2 sm:max-w-fit lg2:px-6 xl:px-6 lg2:py-4 xl:py-4 bg-[#D1A15D] overflow-hidden sm:rounded-lg m-auto" @endif class="mt-10 rounded-lg  mb-10 w-1/2 sm:max-w-fit px-6 py-4 bg-[#D1A15D] overflow-hidden sm:rounded-lg m-auto" x-data="{ open: false }">
            <!-- Product preview button -->
            <button id="previewProduct" wire:click="toggleLightBox" class="col-start-1 lg:col-span-2 lg2:col-start-1 xl:col-start-1 lg2:col-span-1 xl:col-span-1 justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" x-on:click="open = ! open" x-data="{ toggle: false }" x-bind:class="toggle ? ' bg-gray-900 text-white' : ''" @click="toggle = ! toggle">
                Preview Product
            </button>
            <div class="p-6 items-center rounded-s-full mt-10 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 gap-6" x-show="open" x-transition>
                <!-- Product elements preview -->
                <!-- Main div for grid -->
                <div @if($lightBox) class="justify-center sm:w-[80%] sm:m-auto md:w-[70%] lg2:w-auto xl:w-auto items-center lg2:grid xl:grid lg2:grid-flow-col xl:grid-flow-col lg2:grid-rows-1 xl:grid-rows-1 gap-4" @endif class="justify-center items-center grid grid-flow-col grid-rows-1 gap-4">
                    <!-- div for Images -->
                    <div class="lg2:grid xl:grid flex justify-center gap-x-4 gap-y-4 flex-wrap flex-row content-center lg2:col-span-2 xl:col-span-2 lg2:row-span-3 xl:row-span-3">
                        @foreach ($productImage as $image)
                        <img class="rounded-lg" src="{{$image->temporaryUrl()}}" width="200">
                        <hr class="mt-2 mb-2 hidden lg2:block xl:block">
                        @endforeach

                    </div>
                    <!-- div for second column in preview -->
                    <div class="lg2:grid xl:grid lg2:p-[5rem] xl:p-[5rem] row-start-1 gap-6 mt-8">
                        @if(!empty($colorRender))
                        <div class="row-span-1 justify-center items-center flex">
                            Available in:
                            @foreach ($colorRender as $index => $bgColor)
                            <div wire:model="colorRender.{{ $index }}" class="m-1 border-2" wire:key="{{$index}}" style="width: 25px; height: 25px; background-color:{{$bgColor}}; border-radius: 50%;"></div>
                            @endforeach
                        </div>
                        @endif
                        <hr class="mt-2 mb-2">
                        <!-- div for Product name and description -->
                        <div class="items-center gap-2 col-span-1">
                            <p class="text-4xl text-gray-900 dark:text-white">{{$productName}}</p>
                            <hr class="mt-2 mb-2 h-px">
                            <p class="max-w-lg sm:m-auto text-lg leading-relaxed text-[#333333] text-justify text-balance dark:text-white"> {{$productDescription}}</p>
                            <hr class="mt-2 mb-2">
                        </div>
                        <!-- div for Product name and description -->
                        <div class="items-center gap-2 col-span-1">
                            @if(isset($productDiscount) && !empty($productDiscount))
                            <p class="text-xl text-[#9E1B32]"> Current Discount: - {{$productDiscount}} %</p>
                            <p class="text-xl text-gray-900">Price: {{number_format($productDiscountedPrice, 2,'.',' ')}} $
                            <p class="text-gray-400">+ {{number_format(\App\Livewire\AddProduct::DELIVERY,2, '.', ' ')}}$ shipping</p>
                            <p class="line-through">From: {{number_format($productPrice, 2, '.', ' ')}} $</p>
                            @endif
                            @if(isset($productPrice) && empty($productDiscount))
                            <p class="text-xl ">Price: {{number_format($productPrice, 2, '.', ' ')}} $</p>
                            <p class="text-gray-400">+ {{number_format(\App\Livewire\AddProduct::DELIVERY,2, '.', ' ')}}$ shipping</p>
                            @endif
                        </div>
                        <div class="items-center gap-2 rown-start-2 col-span-1"><!-- div for categories -->
                            <hr class="mt-2 mb-2">
                            @if(!empty($genderSelect))
                            <p>{{ implode(', ', $genderSelect) }}</p>
                            @endif
                            @if(!empty($heelSelect))
                            <p>Heel type: {{ implode(', ', $heelSelect) }}</p>
                            @endif
                            @if(!empty($materialSelect))
                            <p>Made from: {{ implode(', ', $materialSelect) }}</p>
                            @endif
                            @if(!empty($sizeSelect))
                            <p class="p-[1rem] text-lg text-gray-900">Available sizes: {{ implode(', ', $sizeSelect) }}</p>
                            @endif
                            @if(!empty($typeSelect))
                            <p>Type: {{ implode(', ', $typeSelect) }}</p>
                            @endif
                            <hr class="mt-2 mb-2">
                            @if(isset($productPrice) && isset($startDate) && !empty($productDiscount))
                            <p class="text-[#9E1B32]"> Discount valid from: {{$startDate}} to {{$endDate}}</p>
                            @endif
                            <hr class="mt-2 mb-6">
                            @if(!empty($tagSelect))
                            <p class="mb-4 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="25" height="25">
                                    <path d="M21.526,8.284L13.937,.879C13.278,.219,12.33-.104,11.409,.028L4.521,.97c-.547,.075-.93,.579-.855,1.126,.075,.547,.578,.929,1.127,.855l6.889-.942c.306-.042,.622,.063,.851,.292l7.59,7.405c1.045,1.045,1.147,2.68,.323,3.847-.234-.467-.523-.912-.911-1.3l-7.475-7.412c-.658-.658-1.597-.975-2.528-.851l-6.889,.942c-.454,.062-.808,.425-.858,.881l-.765,6.916c-.1,.911,.214,1.804,.864,2.453l7.416,7.353c.944,.945,2.199,1.464,3.534,1.464h.017c1.342-.004,2.6-.532,3.543-1.487l3.167-3.208c.927-.939,1.393-2.159,1.423-3.388l.577-.576c1.925-1.95,1.914-5.112-.032-7.057Zm-15.526,1.716c-.552,0-1-.448-1-1,.006-1.308,1.994-1.307,2,0,0,.552-.448,1-1,1Z" />
                                </svg> Tags:</p>
                            <div class="flex flex-wrap gap-y-2 gap-x-2 justify-center">
                                @foreach ($tagSelect as $tagSelect)
                                <span class="bg-gray-900 text-[#FFFFFF] p-[0.5rem] rounded-lg">{{ $tagSelect }}</span>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <hr class="mt-2 mb-2">
    </div>
</div>