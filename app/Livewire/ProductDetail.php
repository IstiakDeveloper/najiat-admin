<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductDetail extends Component
{
    public $product;
    public $pdfUrl;

    public function mount($productId)
    {
        // Fetch product details from the database based on $productId
        $this->product = Product::findOrFail($productId);
    }

    public function render()
    {
        return view('livewire.product-detail');
    }

    public function showPdf()
    {
        $pdfPath = "storage/{$this->product->pdf_file}";
        $pdfUrl = asset(url($pdfPath));

        $this->pdfUrl = $pdfUrl;
        $this->dispatch('showPdf', ['pdfUrl' => $pdfUrl]);
    }



}
