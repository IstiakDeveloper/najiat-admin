<div class="container mx-auto my-8">
    <h1 class="text-3xl font-semibold mb-6">Shopping Cart</h1>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cart as $item)
                <div class="bg-white p-4 rounded-md shadow-md relative">
                    <div class="relative">
                        @if(isset($item['image']))
                            <img src="{{asset('storage/'. $item['image'] )}}" alt="{{ $item['name'] }}" class="w-full h-40 object-cover mb-4 rounded-md">
                        @else
                            <span class="block w-full h-40 bg-gray-300 mb-4 rounded-md"></span>
                        @endif
                        <button wire:click="deleteCartItem({{ $item['id'] }})" onclick="confirm('Are you sure you want to remove this item?') || event.stopImmediatePropagation()" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <h2 class="text-lg font-semibold mb-2">{{ $item['name'] }}</h2>
                        <p class="text-gray-500 mb-2">{{ isset($item['description']) ? $item['description'] : '' }}</p>
                        <p class="text-gray-500 mb-2">Price: {{ ' ' . isset($item['sale_price']) ? $item['sale_price'] : '' }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center space-x-2">
                            <button wire:click="decreaseQuantity({{ $item['id'] }})" class="text-red-500 hover:text-red-700 border border-red-500 px-2 rounded-full">-</button>
                            <p class="text-gray-700">Quantity: {{ $item['quantity'] }}</p>
                            <button wire:click="increaseQuantity({{ $item['id'] }})" class="text-green-500 hover:text-green-700 border border-green-500 px-2 rounded-full">+</button>
                        </div>
                        @php
                            $subtotal = $item['quantity'] * $item['sale_price'];
                        @endphp
                        <p class="text-gray-700">Subtotal: ${{ $subtotal }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <p class="text-xl font-semibold mb-2">Order Summary</p>
            <div class="flex justify-between items-center mb-2">
                <p class="text-gray-700">Total Items: {{ count($cart) }}</p>
            </div>
            @php
                $totalQuantity = 0;
            @endphp

            @foreach($cart as $item)
                @php
                    $quantity = $item['quantity'];
                    $totalQuantity +=$quantity;
                @endphp
            @endforeach
            <div class=" items-center mb-4">
                <p class="text-gray-700 mb-2">Total Quantity: {{ $totalQuantity }}</p>
                <p class="text-gray-700">Total Price: ${{ $totalPrice }}</p>
            </div>


            @if($showAddressForm)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center" >
                <div class="bg-white p-6 rounded-md relative" >
                    <!-- Close button in the top-right corner -->
                    <button wire:click="closeOutsideModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <livewire:address-form-component :cart="$cart" />
                </div>
            </div>
        @endif

            @if(!$showAddressForm)
                <div class="flex space-x-4">
                    <button wire:click="toggleModal" class="bg-purple-500 text-white px-4 py-2 rounded-md">Place Order</button>
                    <button wire:click="deleteAllItems" onclick="confirm('Are you sure you want to clear the cart?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700">Clear Cart</button>
                </div>
            @endif
        </div>



    @else
        <p class="text-gray-700 text-center">Your shopping cart is empty.</p>
    @endif



</div>

