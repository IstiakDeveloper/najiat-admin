@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Invoice</h2>

    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $customer->name }}" required>
                </div>
                <div class="col-span-1">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $customer->phone_number }}" required>
                </div>
                <div class="col-span-1">
                    <label for="customer_address" class="block text-sm font-medium text-gray-700">Customer Address</label>
                    <textarea name="customer_address" id="customer_address" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ $customer->address }}</textarea>
                </div>
            </div>
        </div>

        <!-- Rest of the form structure for ordered products and invoice details -->
        <div class="bg-white shadow overflow-hidden mt-6 sm:rounded-lg p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ordered Products</h3>
            <div class="grid grid-cols-1 gap-6">
                <label for="products" class="block text-sm font-medium text-gray-700">Select Products</label>
                <select id="products" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <div id="productQuantities" class="mt-4">
                    <!-- Dynamic content for product quantities will be added here -->
                </div>
            </div>
            <div id="orderedProducts" class="mt-4">
                @foreach ($invoice->orders as $order)
                    <div class="grid grid-cols-3 gap-4">
                        <span class="font-semibold">{{ $order->product->name }}</span>
                        <span>{{ $order->quantity }}</span>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="bg-white shadow overflow-hidden mt-6 sm:rounded-lg p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Invoice Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
                    <input type="text" name="discount" id="discount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $invoice->discount }}">
                </div>
                <div class="col-span-1">
                    <label for="delivery_charge" class="block text-sm font-medium text-gray-700">Delivery Charge</label>
                    <input type="text" name="delivery_charge" id="delivery_charge" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $invoice->delivery_charge }}">
                </div>


            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">Update Invoice</button>
        </div>

        @if ($errors->any())
        <div class="mt-4">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productsSelect = document.getElementById("products");
        const productQuantitiesContainer = document.getElementById("productQuantities");

        productsSelect.addEventListener("change", function() {
            const selectedProductId = productsSelect.value;
            if (selectedProductId) {
                const productQuantityDiv = document.createElement("div");
                productQuantityDiv.classList.add("grid", "grid-cols-2", "gap-4", "mt-4");

                const productLabel = document.createElement("span");
                productLabel.textContent = `Selected Product: ${productsSelect.options[productsSelect.selectedIndex].text}`;
                productQuantityDiv.appendChild(productLabel);

                const productQuantityInput = document.createElement("input");
                productQuantityInput.type = "number"; // Change to number input for quantity
                productQuantityInput.name = `products[${selectedProductId}][quantity]`; // Use array with 'quantity' key
                productQuantityInput.value = 1;
                productQuantityInput.placeholder = "Quantity";
                productQuantityInput.classList.add("mt-1", "focus:ring-indigo-500", "focus:border-indigo-500", "block", "w-full", "py-2", "px-3", "border", "border-gray-300", "rounded-md", "shadow-sm", "sm:text-sm");
                productQuantityDiv.appendChild(productQuantityInput);

                productQuantitiesContainer.appendChild(productQuantityDiv);
            }
        });
    });
</script>
@endsection
