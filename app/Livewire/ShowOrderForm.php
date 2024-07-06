<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;


class ShowOrderForm extends Component
{
    public $product;
    public $quantity = 1;
    public $deliveryOption;
    public $name;
    public $phone;
    public $address;
    public $deliveryCharge;
    public $discount;
    protected $listeners = ['productSelected'];

    public function productSelected($data)
    {
        $this->product = $data['product'];
        $this->quantity = $data['quantity'];
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.show-order-form');
    }

    public function deliveryOptionUpdateFunction()
    {
        // Update delivery charge based on the selected delivery option
        $this->deliveryCharge = $this->calculateDeliveryCharge();

        // Emit an event to notify cart.blade.php about the updated delivery charge
        $this->dispatch('deliveryChargeUpdated', $this->deliveryCharge);
    }

    private function calculateDeliveryCharge()
    {
        // Modify the calculation based on the selected delivery option
        if ($this->deliveryOption === 'SundarbanCourier') {
            return 40;
        } elseif ($this->deliveryOption === 'HomeDeliveryInsideDhaka') {
            return 50;
        } elseif ($this->deliveryOption === 'HomeDeliveryOutsideDhaka') {
            return 90;
        }

        // Default delivery charge if no option is selected
        return 0;
    }


    public function generateInvoiceNumber() {
        // Get the last invoice with a number like INV-XXXX
        $lastInvoice = Invoice::where('invoice_number', 'like', 'INV-%')->latest()->first();

        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $lastSerialNumber = intval(substr($lastInvoiceNumber, -4));
            $newSerialNumber = $lastSerialNumber + 1;
        } else {
            // If there is no last invoice, start with 528
            $newSerialNumber = 529;
        }

        // Ensure the new serial number is at least 528
        $newSerialNumber = max($newSerialNumber, 529);

        // Format the new invoice number
        $newInvoiceNumber = 'INV-' . str_pad($newSerialNumber, 4, '0', STR_PAD_LEFT);

        return $newInvoiceNumber;
    }


public function placeOrder(Product $product)
    {
        $product = $this->product;
        $this->validate([
            'deliveryOption' => 'required',
            'name' => 'required',
            'phone' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);

        // Create a new customer or find an existing one based on the phone number
        $customer = Customer::updateOrCreate(
            ['phone_number' => $this->phone],
            ['name' => $this->name, 'address' => $this->address]
        );

        // Fetch purchase_price and sale_price from the product
        $purchasePrice = $product->purchase_price;
        $salePrice = $product->sale_price;

        // Calculate total sale and purchase based on quantity
        $totalSale = $salePrice * 1;
        $totalPurchase = $purchasePrice * 1;

        // Calculate COD charge, cashout charge, and total expense
        $cashoutCharge = $totalPurchase * 0.015;
        $codCharge = $totalSale * 0.01;

        // Calculate total expense, total sale, and net profit
        $totalExpense = $totalPurchase + $cashoutCharge + $codCharge + $this->deliveryCharge;

        // Calculate total sale with discount and include delivery charge
        $totalSaleWithDiscount = $totalSale + $this->deliveryCharge - ($this->discount ?? 0);

        // Calculate net profit
        $netProfit = $totalSaleWithDiscount - $totalExpense;

        // Create the invoice
        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'customer_id' => $customer->id,
            'discount' => $this->discount ?? 0,
            'delivery_charge' => $this->deliveryCharge ?? 0,
            'total_expense' => $totalExpense,
            'total_sale' => $totalSaleWithDiscount,
            'delivery_system' => $this->deliveryOption,
            'net_profit' => $netProfit,
            'total_purchase_price' => $totalPurchase,
            'total_sale_price' => $totalSale,
            'delivery_status' => 'Review',
            'note' => 'Website',
        ]);


        // Create the order for the selected product
        Order::create([
            'customer_id' => $customer->id,
            'invoice_id' => $invoice->id,
            'product_id' => $this->product->id,

            'quantity' => 1,
            'discount' => 0, // Set your discount logic here
            'delivery_charge' => $this->deliveryCharge,
            'total_amount' => 1 * $salePrice,
            'total' =>1 * $salePrice + $this->deliveryCharge,
        ]);
        // Clear the cart from the session
        session()->forget('cart');

        // Emit an event to notify other components if needed
        $this->dispatch('orderPlaced', 'Your order has been created.');

        return Redirect::route('home')->with('success', 'Your order is placed.');
    }


    public function orderNow($productId)
    {
        $product = Product::find($productId);

        // Check if the product exists
        if ($this->product) {
            // Assume quantity is 1 for the order now functionality


            // Call the placeOrder method with the product details
            $this->placeOrder($this->product);
        }
    }

    public function updateTotalPrice($totalPrice)
    {
        // Handle the updated total price from cart.blade.php
        // This method will be triggered when the 'totalPriceUpdated' event is received
    }
}
