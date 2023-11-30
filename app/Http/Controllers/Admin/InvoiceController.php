<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InvoicesExport;
use App\Http\Controllers\Controller;
use App\Imports\InvoicesImport;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InvoiceController extends Controller
{
    public function calculateTotalAmount($productId, $quantity) {
        $product = Product::find($productId);

        if (!$product) {
            return 0; // Handle the case when the product is not found
        }

        $totalAmount = ($product->sale_price * $quantity) - $product->purchase_price;

        return $totalAmount;
    }

    public function generateInvoiceNumber() {
        $lastInvoice = Invoice::latest()->first();

        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $lastSerialNumber = intval(substr($lastInvoiceNumber, -4));
            $newSerialNumber = $lastSerialNumber + 1;
        } else {
            $newSerialNumber = 1;
        }

        $newInvoiceNumber = 'INV-' . str_pad($newSerialNumber, 4, '0', STR_PAD_LEFT);

        return $newInvoiceNumber;
    }

    public function create()
    {
        // Fetch any necessary data for the form (e.g., products)
        $products = Product::all();

        return view('admin.invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'customer_name' => 'required',
            'phone_number' => 'required',
            'customer_address' => 'required',
            'products' => 'required|array',
        ]);

        // Ensure at least one product is selected
        if (empty($request->products)) {
            return redirect()->back()->withErrors(['products' => 'At least one product is required.']);
        }

        // Find or create a customer based on the contact number
        $customer = Customer::updateOrCreate(
            ['phone_number' => $request->phone_number],
            ['name' => $request->customer_name, 'address' => $request->customer_address]
        );

        // Initialize variables to calculate totals
        $totalSale = 0;
        $totalPurchase = 0;
        $totalQuantity = 0; // Used for total quantity of all products

        // Iterate over selected products
        foreach ($request->products as $productId => $productData) {
            $quantity = $productData['quantity'];
            $product = Product::find($productId);

            if ($product) {
                // Fetch purchase_price and sale_price from the product
                $purchasePrice = $product->purchase_price;
                $salePrice = $product->sale_price;

                // Calculate total sale and purchase based on quantity
                $totalSale += $salePrice * $quantity;
                $totalPurchase += $purchasePrice * $quantity;
                $totalQuantity += $quantity; // Accumulate quantity for all products
            }
        }

        // Calculate COD charge, cashout charge, and total expense
        $cashoutCharge = $totalPurchase * 0.015;
        $codCharge = $totalSale * 0.01;

        // Calculate total expense, total sale, and net profit
        $totalExpense = $totalPurchase + $cashoutCharge + $codCharge + $request->delivery_charge;

        // Calculate total sale with discount and include delivery charge
        $totalSaleWithDiscount = $totalSale + $request->delivery_charge - ($request->discount ?? 0);

        // Calculate net profit
        $netProfit = $totalSaleWithDiscount - $totalExpense;

        // Create the invoice with the calculated totals
        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'customer_id' => $customer->id,
            'discount' => $request->discount ?? 0,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'total_expense' => $totalExpense,
            'total_sale' => $totalSaleWithDiscount,  // Include delivery and discount here
            'net_profit' => $netProfit,
            'total_purchase_price' => $totalPurchase,  // Include total purchase price here
            'total_sale_price' => $totalSale,  // Include total sale price here
            'delivery_status' => 'Pending', // Default delivery status
            'note' => $request->note,
        ]);


        foreach ($request->products as $productId => $productData) {
            $quantity = $productData['quantity'];
            $product = Product::find($productId);

            if ($product) {
                // Create an order for each product in the invoice
                Order::create([
                    'customer_id' => $customer->id,
                    'invoice_id' => $invoice->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'discount' => $request->discount,
                    'delivery_charge' => $request->delivery_charge,
                    'total_amount' => $quantity * $product->sale_price - $quantity * $product->purchase_price,
                    'total' => $quantity * $product->sale_price + $request->delivery_charge + $codCharge,
                ]);

                if ($product->stock_quantity >= $quantity) {
                    $product->decrement('stock_quantity', $quantity);
                }
            }
        }


        // Redirect to the invoice show page with a success message
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }




    public function index()
    {
        $invoices = Invoice::with('orders.product')->get();

        // Initialize an array to store invoice data
        $invoiceData = [];

        foreach ($invoices as $invoice) {
            $totalSale = 0;
            $totalPurchase = 0;
            $combinedQuantity = 0;

            foreach ($invoice->orders as $order) {
                // If product_id is null, it's a combined order for multiple products
                if ($order->product_id) {
                    $totalSale += $order->product->sale_price * $order->quantity;
                    $totalPurchase += $order->product->purchase_price * $order->quantity;
                } else {
                    // This is a combined order, use combined quantities and amounts
                    $combinedQuantity += $order->quantity;
                    $totalSale += $order->total_amount;
                    $totalPurchase += $order->product->purchase_price * $order->quantity;
                }
            }

            // Calculate total expense, net profit, cashout charge, and COD charge
            $deliveryCharge = $invoice->delivery_charge;
            $cashoutCharge = $totalSale * 0.0115;
            $codCharge = $totalSale * 0.01;
            $totalExpense = $totalPurchase + $cashoutCharge + $deliveryCharge + $codCharge;
            $netProfit = $totalSale - $totalExpense;

            // Store invoice data
            $invoiceData[$invoice->id] = [
                'totalSale' => $totalSale,
                'totalExpense' => $totalExpense,
                'netProfit' => $netProfit,
                'combinedQuantity' => $combinedQuantity,
            ];
        }

        return view('admin.invoices.index', compact('invoices', 'invoiceData'));
    }




    public function edit(Invoice $invoice)
    {
        $products = Product::all();
        $customer = $invoice->customer;
        return view('admin.invoices.edit', compact('invoice', 'products', 'customer'));
    }
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone_number' => 'required|unique:customers,phone_number,' . $invoice->customer_id,
            'customer_address' => 'required',
            'products' => 'required|array|min:1'
        ]);

        // Update the customer data
        $invoice->customer->update([
            'name' => $request->input('customer_name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('customer_address'),
        ]);

        // Update the invoice data
        $invoice->update([
            'discount' => $request->input('discount') ?? 0,
            'delivery_charge' => $request->input('delivery_charge') ?? 0,
        ]);

        // Update or create orders based on the provided products
        foreach ($request->input('products') as $productData) {
            // Check if the 'product_id' key exists in the $productData array
            if (!isset($productData['product_id'])) {
                // Handle the missing 'product_id' key (e.g., log an error, skip the product, etc.)
                continue;
            }

            $product = Product::find($productData['product_id']);

            if ($product) {
                // Update or create the order for the product
                $order = Order::updateOrCreate(
                    [
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => $productData['quantity'],
                        // Add any other order-related fields here
                    ]
                );
            }
        }


        // Perform any additional calculations or logic for the update

        // Redirect to the invoice show page with a success message
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }





    public function show(Invoice $invoice)
    {
        // Calculate total expense and total profit
        $totalExpense = 0;
        foreach ($invoice->orders as $order) {
            $product = $order->product;
            $cashoutCharge = $product->purchase_price * 0.015;
            $codCharge = $product->sale_price * 0.01;
            $totalExpense += $product->purchase_price + $cashoutCharge + $invoice->delivery_charge + $codCharge;
        }

        $totalSale = 0;
        foreach ($invoice->orders as $order) {
            $product = $order->product;
            $totalSale += $product->sale_price * $order->quantity;
        }

        $totalProfit = $totalSale - $totalExpense;

        $invoice->load('orders.product'); // Make sure the relationship path is correct
        return view('admin.invoices.show', compact('invoice', 'totalExpense', 'totalProfit'));
    }

    public function print(Invoice $invoice)
    {
        // Make sure $invoice is an instance of Invoice
        return view('admin.invoices.print', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        // Logic for generating and downloading PDF
        $pdf = PDF::loadView('admin.invoices.print', compact('invoice')); // Use the appropriate view name

        $pdfPath = storage_path('app/public/invoices/');
        if (!Storage::exists($pdfPath)) {
            Storage::makeDirectory($pdfPath, 0755, true, true);
        }

        $pdfFileName = $invoice->invoice_number . '.pdf';
        $pdf->save($pdfPath . $pdfFileName);

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->download($pdfPath . $pdfFileName, $pdfFileName, $headers);
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.csv');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->orders()->delete();
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function importForm()
    {
        return view('admin.invoices.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        Excel::import(new InvoicesImport, $file);

        return redirect()->back()->with('success', 'Invoices imported successfully.');
    }

    public function editStatus(Invoice $invoice)
    {
        return view('admin.invoices.edit-status', compact('invoice'));
    }


    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'delivery_status' => 'required|in:Pending,Complete,Cancel',
        ]);

        // Check if the status is being updated to cancel
        if ($request->delivery_status === 'Cancel') {
            // If canceled, loop through orders and update product stock_quantity
            foreach ($invoice->orders as $order) {
                $product = $order->product;

                // Increment the stock_quantity with the order quantity
                $product->increment('stock_quantity', $order->quantity);
            }

            // Set specific fields to 0 in the invoice
            $invoice->update([
                'discount' => 0,
                'total_expense' => 0,
                'total_sale' => 0,
                'net_profit' => 0,
                'total_purchase_price' => 0,
                'total_sale_price' => 0,
            ]);
        }

        // Update the delivery status of the invoice
        $invoice->update([
            'delivery_status' => $request->delivery_status,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice status and delivery status updated successfully.');
    }

}
