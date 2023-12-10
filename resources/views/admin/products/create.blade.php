@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-semibold mb-6">Create Product</h1>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 block w-full border rounded-md @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                <input type="text" id="short_description" name="short_description" class="mt-1 p-2 block w-full border rounded-md @error('short_description') border-red-500 @enderror" value="{{ old('short_description') }}">
                @error('short_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 p-2 block w-full border rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="mt-1 @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pdf_file" class="block text-sm font-medium text-gray-700">PDF File</label>
                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" class="mt-1 @error('pdf_file') border-red-500 @enderror">
                @error('pdf_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image_gallery" class="block text-sm font-medium text-gray-700">Product Image Gallery</label>
                <input type="file" id="image_gallery" name="image_gallery[]" accept="image/*" multiple class="mt-1 @error('image_gallery') border-red-500 @enderror">
                @error('image_gallery')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                <input type="text" id="author" name="author" class="mt-1 p-2 block w-full border rounded-md @error('author') border-red-500 @enderror" value="{{ old('author') }}">
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="mt-1 p-2 block w-full border rounded-md @error('category_id') border-red-500 @enderror">
                    <option value="" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="purchase_price" class="block text-sm font-medium text-gray-700">Purchase Price</label>
                <input type="number" id="purchase_price" name="purchase_price" class="mt-1 p-2 block w-full border rounded-md @error('purchase_price') border-red-500 @enderror" value="{{ old('purchase_price') }}">
                @error('purchase_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="regular_price" class="block text-sm font-medium text-gray-700">Regular Price</label>
                <input type="number" id="regular_price" name="regular_price" class="mt-1 p-2 block w-full border rounded-md @error('regular_price') border-red-500 @enderror" value="{{ old('regular_price') }}">
                @error('regular_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sale_price" class="block text-sm font-medium text-gray-700">Sale Price</label>
                <input type="number" id="sale_price" name="sale_price" class="mt-1 p-2 block w-full border rounded-md @error('sale_price') border-red-500 @enderror" value="{{ old('sale_price') }}">
                @error('sale_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Product</button>
        </form>
        @if ($errors->any())
        <div class="mt-4">
            <div class="text-red-500 text-sm">
                Please correct the following errors:
            </div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
@endsection
