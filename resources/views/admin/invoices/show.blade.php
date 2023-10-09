@extends('layouts.app')

@section('content')
<div class="p-6 container mx-auto">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-indigo-600 px-4 py-3">
            <h2 class="text-xl font-semibold text-white">Invoice Details</h2>
        </div>
        <div class="px-4 py-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Invoice Number</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->invoice_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Customer</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->customer->name }}</p>
                </div>
                <!-- Add more invoice details as needed -->
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-indigo-600 px-4 py-3">
            <h2 class="text-xl font-semibold text-white">Order Details</h2>
        </div>
        <div class="px-4 py-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Order Number</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->invoice_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Customer Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->customer->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Contact Number</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->customer->phone_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Customer Address</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $invoice->customer->address }}</p>
                </div>
                <!-- Add more order details as needed -->
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-indigo-600 px-4 py-3">
            <h2 class="text-xl font-semibold text-white">Product Details</h2>
        </div>
        <div class="px-4 py-6">
            @foreach ($invoice->orders as $order)
                <div class="border-b border-gray-300 mb-6 pb-4">
                    <p class="text-lg font-semibold text-gray-800">Product: {{ $order->product->name }}</p>
                    <p class="text-sm text-gray-600">Quantity: {{ $order->quantity }}</p>
                    <p class="text-sm text-gray-600">Sale Price: ৳{{ $order->product->sale_price }}</p>
                    <p class="text-sm text-gray-600">Discount: ৳{{ $order->invoice->discount }}</p>
                    @php
                        $subTotal = $order->product->sale_price * $order->quantity - $order->invoice->discount;
                    @endphp
                    <p class="text-sm text-gray-600">Sub-Total: ৳{{$subTotal}}</p>
                    <!-- Add more product details as needed -->
                </div>
            @endforeach
            <p class="text-sm text-gray-600">Delivery Charge: ৳{{ $order->invoice->delivery_charge }}</p>
        </div>

    </div>

    <div class="mt-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-indigo-600 px-4 py-3">
                <h2 class="text-xl font-semibold text-white">Order Total</h2>
            </div>
            <div class="px-4 py-6">
                @php
                    // Calculate the total order amount without delivery charge
                    $totalOrderAmount = $invoice->orders->sum(function($order) {
                        return $order->product->sale_price * $order->quantity - $order->invoice->discount;
                    });

                    // Add the delivery charge once
                    $totalOrderAmount += $invoice->delivery_charge;
                @endphp

                <p class="text-lg font-semibold text-gray-800">Total: ৳{{ $totalOrderAmount }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">Edit Invoice</a>
        <a href="{{ route('invoices.print', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition ml-2">Print Invoice</a>
        <a href="{{ route('invoices.download', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition ml-2">Download PDF</a>
    </div>
</div>

<script>
    function printInvoice() {
        window.print(); // Automatically triggers the browser's print functionality
    }
</script>
@endsection
