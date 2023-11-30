<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'author' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:2048',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product([
            'name' => $validatedData['name'],
            'short_description' => $validatedData['short_description'],
            'description' => $validatedData['description'],
            'author' => $validatedData['author'],
            'category_id' => $validatedData['category_id'],
            'purchase_price' => $validatedData['purchase_price'],
            'regular_price' => $validatedData['regular_price'],
            'sale_price' => $validatedData['sale_price'],
            'stock_quantity' => 0,
        ]);

        if ($request->hasFile('image')) {
            // Handle main image upload
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
            $pdfPath = $pdfFile->storeAs('pdfs', $pdfFileName, 'public'); // Store the PDF in the 'storage/app/public/pdfs' directory

            $product->pdf_file = $pdfPath;
        }
        if ($request->hasFile('image_gallery')) {
            $imageGalleryPaths = [];
            foreach ($request->file('image_gallery') as $imageFile) {
                $imageGalleryPath = $imageFile->store('product_images', 'public');
                $imageGalleryPaths[] = $imageGalleryPath;
            }
            $product->image_gallery = json_encode($imageGalleryPaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'author' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->name = $validatedData['name'];
        $product->short_description = $validatedData['short_description'];
        $product->description = $validatedData['description'];
        $product->author = $validatedData['author'];
        $product->category_id = $validatedData['category_id'];
        $product->purchase_price = $validatedData['purchase_price'];
        $product->regular_price = $validatedData['regular_price'];
        $product->sale_price = $validatedData['sale_price'];


        if ($request->hasFile('image')) {
            // Handle main image upload
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
            $pdfPath = $pdfFile->storeAs('pdfs', $pdfFileName, 'public');

            // Delete the old PDF file if it exists
            if ($product->pdf_file) {
                Storage::disk('public')->delete($product->pdf_file);
            }

            $product->pdf_file = $pdfPath;
        }

        if ($request->hasFile('image_gallery')) {
            $imageGalleryPaths = [];
            foreach ($request->file('image_gallery') as $imageFile) {
                $imageGalleryPath = $imageFile->store('product_images', 'public');
                $imageGalleryPaths[] = $imageGalleryPath;
            }
            $product->image_gallery = json_encode($imageGalleryPaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
