<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public $cart = [];

    protected $listeners = ['addToCart', 'increaseQuantity', 'decreaseQuantity', 'totalPriceUpdated'];
    public $showAddressForm = false;
    public $totalPrice = 0;
    public $deliveryCharge = 0;

    public function mount()
    {
        // Initialize cart from session or database
        $this->cart = session('cart', []);
        $this->calculateTotalPrice();
    }

    public function render()
    {
        return view('livewire.cart', [
            'cartCount' => count($this->cart),
            'cartItems' => $this->cart,
            'totalPrice' => $this->totalPrice,
        ]);
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $this->updateCartItem($product, 1);
            $this->dispatch('cartUpdated');
        }
    }

    public function increaseQuantity($productId)
    {
        $this->updateCartItemQuantity($productId, 1);
        $this->calculateTotalPrice();
        $this->dispatch('cartUpdated');
    }

    public function decreaseQuantity($productId)
    {
        $this->updateCartItemQuantity($productId, -1);
        $this->calculateTotalPrice();
        $this->dispatch('cartUpdated');
    }

    protected function updateCartItem($product, $quantity)
    {
        $existingItem = collect($this->cart)->where('id', $product->id)->first();

        if ($existingItem) {
            $existingItem['quantity'] += $quantity;
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'sale_price' => $product->sale_price,
                'regular_price' => $product->regular_price,
                'quantity' => max(1, $quantity),
                'image' => $product->image,
            ];
        }
        $this->updateCartItemSubtotal(count($this->cart) - 1);
        session(['cart' => $this->cart]);
    }

    protected function updateCartItemQuantity($productId, $quantityChange)
    {
        $index = $this->findCartItemIndex($productId);

        if ($index !== false) {
            $this->cart[$index]['quantity'] += $quantityChange;

            // Ensure the quantity is at least 1
            $this->cart[$index]['quantity'] = max(1, $this->cart[$index]['quantity']);

            $this->updateCartItemSubtotal($index);

            session(['cart' => $this->cart]);
        }
    }

    protected function updateCartItemSubtotal($index)
    {
        $this->cart[$index]['subtotal'] = $this->cart[$index]['sale_price'] * $this->cart[$index]['quantity'];
    }


    protected function findCartItemIndex($productId)
    {
        return array_search($productId, array_column($this->cart, 'id'));
    }

    public function deleteCartItem($productId)
    {
        $index = $this->findCartItemIndex($productId);

        if ($index !== false) {
            array_splice($this->cart, $index, 1);
            session(['cart' => $this->cart]);
            $this->dispatch('cartUpdated');
        }
    }

    public function deleteAllItems()
    {
        $this->cart = [];
        session(['cart' => $this->cart]);
        $this->dispatch('cartUpdated');
    }

    public function updateDeliveryCharge($newDeliveryCharge)
    {
        $this->deliveryCharge = $newDeliveryCharge;
        $this->emit('deliveryChargeUpdated', $newDeliveryCharge);
    }

    protected function calculateTotalPrice()
    {
        $this->totalPrice = array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['sale_price'] * $item['quantity']);
        }, 0);
    }

    public function toggleModal()
    {
        $this->showAddressForm = !$this->showAddressForm;
    }
    public function closeOutsideModal()
    {
        // Close the modal when clicking outside
        $this->showAddressForm = false;
    }

    public function updateTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        $this->calculateTotalPrice(); // Recalculate the total price after updating
    }

    public function placeOrder()
    {
        $this->toggleModal();
    }


}
