@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-semibold mb-6">Product List</h1>
        @if(session('success'))
            <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create Product</a>
        <table class="w-full border mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Name</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-2 px-4 border">Author</th>
                    <th class="py-2 px-4 border">Category</th>
                    <th class="py-2 px-4 border">Purchase Price</th>
                    <th class="py-2 px-4 border">Regular Price</th>
                    <th class="py-2 px-4 border">Sale Price</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white ">
                @foreach ($products as $product)
                    <tr>
                        <td class="py-2 px-4">{{ $product->id }}</td>
                        <td class="py-2 px-4">{{ $product->name }}</td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <img class="w-12 h-12 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                </div>
                            </div>
                        </td>
                        <td class="py-2 px-4">{{ $product->author }}</td>
                        <td class="py-2 px-4">{{ $product->category->name }}</td>
                        <td class="py-2 px-4">{{ $product->purchase_price  }}</td>
                        <td class="py-2 px-4">{{ $product->regular_price }}</td>
                        <td class="py-2 px-4">{{ $product->sale_price }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
