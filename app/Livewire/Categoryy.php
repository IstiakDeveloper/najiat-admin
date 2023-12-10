<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Categoryy extends Component
{
    public $category;
    public $products;

    public function mount($categoryId)
    {
        // Fetch category details from the database based on $categoryId
        $this->category = Category::findOrFail($categoryId);
        $this->products = $this->category->products; // Assuming you have a 'products' relationship in your Category model
    }

    public function render()
    {
        return view('livewire.categoryy');
    }
}
