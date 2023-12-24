<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductDetail extends Component
{
    public $product;
    public $relatedProducts;
    public $pdfUrl;
    public $showOrderForm = false;
    public $selectedProduct;
    public $selectedQuantity;

    public function mount($productId)
    {
        // Fetch product details from the database based on $productId
        $this->product = Product::findOrFail($productId);
        $this->relatedProducts = Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->limit(10)
            ->get();
    }
    public function showProduct($productId)
    {
        // Load the clicked related product
        $this->product = Product::find($productId);

        // Load related products again if needed
        $this->relatedProducts = Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->limit(10)
            ->get();
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
