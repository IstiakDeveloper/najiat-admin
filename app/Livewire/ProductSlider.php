<?php

namespace App\Livewire;

use Livewire\Component;

class ProductSlider extends Component
{
    public $products;

    public function mount($products)
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('livewire.product-slider');
    }
}
