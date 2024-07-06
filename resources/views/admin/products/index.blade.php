@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 sm:p-8">
        <h1 class="text-2xl font-semibold mb-4">Product List</h1>
        @if(session('success'))
            <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4 inline-block">Create Product</a>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border hidden sm:table-cell">ID</th>
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Image</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Author</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Category</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Purchase Price</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Regular Price</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Sale Price</th>
                        <th class="py-2 px-4 border hidden sm:table-cell">Stock Quantity</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($products as $product)
                        <tr>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->id }}</td>
                            <td class="py-2 px-4 border text-center">{{ $product->name }}</td>
                            <td class="py-3 px-6 border hidden sm:table-cell text-center">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <img class="w-12 h-12 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>
                            </td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->author }}</td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->category->name }}</td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->purchase_price }}</td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->regular_price }}</td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->sale_price }}</td>
                            <td class="py-2 px-4 border hidden sm:table-cell text-center">{{ $product->stock_quantity }}</td>
                            <td class="py-2 px-4 border text-center">
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
    </div>
@endsection
