<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class AddressFormComponent extends Component
{
    public $cart;
    public $deliveryOption;
    public $name;
    public $phone;
    public $address;
    public $deliveryCharge;
    public $totalPrice = 0;


    protected $listeners = ['totalPriceUpdated' => 'updateTotalPrice'];


    public function render()
    {
        return view('livewire.address-form-component');
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

    public function placeOrder()
    {
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

        // Initialize variables to calculate totals
        $totalSale = 0;
        $totalPurchase = 0;
        $totalQuantity = 0;

        // Iterate over selected products
        foreach ($this->cart as $item) {
            $quantity = $item['quantity'];
            $product = Product::find($item['id']);

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

        // ... (rest of the method)

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
            'net_profit' => $netProfit,
            'total_purchase_price' => $totalPurchase,
            'total_sale_price' => $totalSale,
            'delivery_status' => 'Pending',
            'note' => 'hello',
        ]);

        // Create an order for each product in the cart
        foreach ($this->cart as $item) {
            $quantity = $item['quantity'];
            $totalSale += $item['sale_price'] * $quantity;
            $totalQuantity += $quantity;

            Order::create([
                'customer_id' => $customer->id,
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'quantity' => $quantity,
                'discount' => 0, // Set your discount logic here
                'delivery_charge' => $this->deliveryCharge,
                'total_amount' => $quantity * $item['sale_price'],
                'total' => $quantity * $item['sale_price'] + $this->deliveryCharge,
            ]);
        }

        $this->cart = [];
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
            if ($product) {
                // Assume quantity is 1 for the order now functionality
                $quantity = 1;

                // Update cart with the selected product
                $this->cart = [
                    'id' => $product->id,
                    'quantity' => $quantity,
                    'sale_price' => $product->sale_price,
                    // Add other necessary information about the product
                ];

                // Calculate delivery charge and update total price
                $this->deliveryChargeUpdateFunction();

                // Place the order using the existing placeOrder method
                $this->placeOrder();
            }
        }

    public function updateTotalPrice($totalPrice)
    {
        // Handle the updated total price from cart.blade.php
        // This method will be triggered when the 'totalPriceUpdated' event is received
    }


}
