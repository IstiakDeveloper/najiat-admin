<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{

    public $showOrderForm = false;
    public $selectedProduct;
    public $selectedQuantity;
    public function render()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('livewire.home', [
            'products' => $products,
            'categories'=> $categories,
        ]);
    }
    public $cart = [];

    public function mount()
    {
        // Initialize cart from session or database
        $this->cart = session('cart', []);
    }


    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            // Check if the product is already in the cart
            $existingIndex = $this->findCartItemIndex($productId);

            if ($existingIndex !== false) {
                // If the product is already in the cart, update the quantity
                $this->cart[$existingIndex]['quantity'] += 1;
            } else {
                // If the product is not in the cart, add a new entry
                $this->cart[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'sale_price' => $product->sale_price,
                    'regular_price' => $product->regular_price,
                    'quantity' => 1,
                    'image' => $product->image,
                ];
            }

            // Update session with the new cart data
            session(['cart' => $this->cart]);
            // Dispatch the event to notify other Livewire components about the cart update
            $this->dispatch('cartUpdated');
        }
    }

    protected function findCartItemIndex($productId)
    {
        // Assuming $this->cart is an array with 'id' as the product identifier
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $productId) {
                return $index;
            }
        }

        return false;
    }

    public function toggleModal($productId, $quantity = 1)
    {
        $product = Product::find($productId);

        if ($product) {
            $this->selectedProduct = $product;
            $this->selectedQuantity = $quantity; // Assuming you have a property like $selectedQuantity in your component
            $this->showOrderForm = true;
            $this->dispatch('productSelected', [
                'product' => $this->selectedProduct,
                'quantity' => $this->selectedQuantity,
            ]);

        }
    }
    public function closeOutsideModal()
    {
        // Close the modal when clicking outside
        $this->showOrderForm = false;
    }







}
