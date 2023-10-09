<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            /* Customize styles for printing */
            body {
                background-color: white; /* Set the background color for printing */
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-3xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <!-- Invoice Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold">Invoice</h1>
            <p class="text-gray-600">{{ $invoice->invoice_number }}</p>
        </div>

        <!-- Customer Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Customer Information</h2>
            <p class="text-gray-600">Customer: {{ $invoice->customer->name }}</p>
            <p class="text-gray-600">Contact: {{ $invoice->customer->contact_number }}</p>
            <p class="text-gray-600">Address: {{ $invoice->customer->address }}</p>
        </div>

        <!-- Order Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Order Details</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 text-left">Product</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Sale Price</th>
                        <th class="py-2 px-4 text-left">Discount</th>
                        <th class="py-2 px-4 text-left">Sub-Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->orders as $order)
                        <tr>
                            <td class="py-2 px-4">{{ $order->product->name }}</td>
                            <td class="py-2 px-4">{{ $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->sale_price }}</td>
                            <td class="py-2 px-4">{{ $order->invoice->discount }}</td>
                            @php
                                // Calculate the sub-total for each product
                                $subTotal = ($order->product->sale_price * $order->quantity) - $order->invoice->discount;
                            @endphp
                            <td class="py-2 px-4">৳{{ $subTotal }}</td>
                        </tr>
                    @endforeach
                    <td class="py-2 px-4"><strong>Delivery Charge: </strong>৳{{ $order->invoice->delivery_charge }}</td>
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Total</h2>
            <p class="text-gray-600">Total: ৳{{ $invoice->orders->sum(function($order) {
                return ($order->product->sale_price * $order->quantity) - $order->invoice->discount + $order->invoice->delivery_charge;
            }) }}</p>
        </div>
    </div>
</body>
</html>
