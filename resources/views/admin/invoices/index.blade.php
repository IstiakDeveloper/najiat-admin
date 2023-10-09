@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Invoices</h1>
    @php
        $totalExpenseSum = $invoices->sum('total_expense');
        $totalSaleSum = $invoices->sum('total_sale');
        $netProfitSum = $invoices->sum('net_profit');
    @endphp

    <div class="flex justify-between mb-4">
        <div>
            <a href="{{ route('invoices.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">Create Invoice</a>
        </div>
        <div>
            <p class="text-lg font-semibold">Total Expense Sum: ৳{{ $totalExpenseSum }}</p>
        </div>
        <div>
            <p class="text-lg font-semibold">Total Sale Price Sum: ৳{{ $totalSaleSum }}</p>
        </div>
        <div>
            <p class="text-lg font-semibold">Net Profit Sum: ৳{{ $netProfitSum }}</p>
        </div>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Invoice Number</th>
                    <th class="py-2 px-4 text-left">Order ID</th>
                    <th class="py-2 px-4 text-left">Product Name</th>
                    <th class="py-2 px-4 text-left">Quantity</th>
                    <th class="py-2 px-4 text-left">Purchase Price</th>
                    <th class="py-2 px-4 text-left">Sale Price</th>
                    <th class="py-2 px-4 text-left">Cashout Charge</th>
                    <th class="py-2 px-4 text-left">COD Charge</th>
                    <th class="py-2 px-4 text-left">Delivery Charge</th>
                    <th class="py-2 px-4 text-left">Discount</th>
                    <th class="py-2 px-4 text-left">Total Expense</th>
                    <th class="py-2 px-4 text-left">Total Sale</th>
                    <th class="py-2 px-4 text-left">Net Profit</th>
                    <th class="py-2 px-4 text-left">Delivery Status</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    @foreach ($invoice->orders as $index => $order)
                        <tr class="hover:bg-gray-50 transition border-t border-gray-200">
                            @if ($index === 0)
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->invoice_number }}</td>
                            @endif
                            <td class="py-2 px-4">{{ $order->id }}</td>
                            <td class="py-2 px-4">{{ $order->product->name }}</td>
                            <td class="py-2 px-4">{{ $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->purchase_price * $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->sale_price * $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->purchase_price * 0.015 * $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->sale_price * 0.01 * $order->quantity }}</td>
                            @if ($index === 0)
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->delivery_charge }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->discount }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->total_expense }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->total_sale }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->net_profit }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->delivery_status }}</td>
                                <!-- Actions -->
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2">
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-green-500 hover:text-green-700 ml-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
