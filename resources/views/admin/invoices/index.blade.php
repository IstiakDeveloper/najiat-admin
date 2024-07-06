@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold mb-4">Invoices</h1>
        </div>
        <div>
            <a href="{{ route('export.invoices') }}" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">Export invoice</a>
            <a href="{{ route('import.invoices.form') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">Import Invoices</a>
        </div>
    </div>
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
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Date</th>
                    <th class="py-2 px-4 text-left">Customer Name</th>
                    <th class="py-2 px-4 text-left">Invoice Number</th>
                    <th class="py-2 px-4 text-left">Order ID</th>
                    <th class="py-2 px-4 text-left">Product Name</th>
                    <th class="py-2 px-4 text-left">Quantity</th>
                    <th class="py-2 px-4 text-left">Purchase Price</th>
                    <th class="py-2 px-4 text-left">Sale Price</th>
                    <th class="py-2 px-4 text-left">Delivery Charge</th>
                    <th class="py-2 px-4 text-left">Discount</th>
                    <th class="py-2 px-4 text-left">Total Expense</th>
                    <th class="py-2 px-4 text-left">Total Sale</th>
                    <th class="py-2 px-4 text-left">Net Profit</th>
                    <th class="py-2 px-4 text-left">Delivery System</th>
                    <th class="py-2 px-4 text-left">Delivery Status</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    @foreach ($invoice->orders as $index => $order)
                    @php
                    $rowClass = ' transition';
                    if ($invoice->delivery_status === 'Cancel') {
                        $rowClass .= ' bg-red-100 border border-gray-500 border-2'; // Set red background and black border for canceled status
                    } elseif ($invoice->delivery_status === 'Complete') {
                        $rowClass .= ' bg-green-100 border border-gray-500 border-2'; // Set green background and black border for completed status
                    } elseif ($invoice->delivery_status === 'Pending') {
                        $rowClass .= ' bg-blue-100 border border-gray-500 border-2'; // Set blue background and black border for pending status
                    } else {
                        $rowClass .= ' bg-gray-100 border border-gray-500 border-2'; // Set gray background and black border for other statuses
                    }
                @endphp
                    <tr class="{{ $rowClass }}">
                            @if ($index === 0)
                                <!-- Display the customer name only once for the first order in the invoice -->
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->created_at->format('d-m-Y') }}</td>
                            @endif
                            @if ($index === 0)
                                <!-- Display the customer name only once for the first order in the invoice -->
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->customer->name }}</td>
                            @endif
                            @if ($index === 0)
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->invoice_number }}</td>
                            @endif
                            <td class="py-2 px-4">{{ $order->id }}</td>
                            <td class="py-2 px-4">{{ $order->product->name }}</td>
                            <td class="py-2 px-4">{{ $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->purchase_price * $order->quantity }}</td>
                            <td class="py-2 px-4">{{ $order->product->sale_price * $order->quantity }}</td>
                            @if ($index === 0)
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->delivery_charge }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->discount }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->total_expense }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->total_sale }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->net_profit }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->delivery_system }}</td>
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2 px-4">{{ $invoice->delivery_status }}</td>
                                <!-- Actions -->
                                <td rowspan="{{ count($invoice->orders) }}" class="py-2">
                                    @if ($invoice->delivery_status !== 'Cancel')
                                        <a href="{{ route('invoices.editStatus', $invoice) }}" class="text-green-500 hover:text-green-700 mr-2">
                                            <i class="fa-solid fa-repeat"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-green-500 hover:text-green-700 ml-2">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form method="post" action="{{ route('invoices.pushToSteadfast', $invoice) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Push to Steadfast</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
</div>





@endsection
