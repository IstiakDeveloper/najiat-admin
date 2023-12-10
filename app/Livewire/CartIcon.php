<?php

namespace App\Livewire;

use Livewire\Component;

class CartIcon extends Component
{
    protected $listeners = ['cartUpdated'];
    public function render()
    {

        $cartCount = count(session('cart', []));



        return view('livewire.cart-icon', [
            'cartCount' => $cartCount,

        ]);

    }

    public function cartUpdated()
    {
        // This method is called when the cart is updated
        // Fetch the latest cart count and update the Livewire component
        $this->render();
    }


}
