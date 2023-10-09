<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Make sure to import the correct namespace for your Order model
use App\Models\Customer;
use App\Models\Invoice;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'invoice')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $invoices = Invoice::all();
        return view('orders.create', compact('customers', 'invoices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'required|exists:invoices,id',
            // Add validation rules for other order-related fields
        ]);

        $order = Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('customer', 'invoice');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $invoices = Invoice::all();
        return view('orders.edit', compact('order', 'customers', 'invoices'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'required|exists:invoices,id',
            // Add validation rules for other order-related fields
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
