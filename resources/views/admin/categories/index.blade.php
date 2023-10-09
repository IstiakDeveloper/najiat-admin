@extends('layouts.app')

@section('content')
    <div class="p-6 container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Category List</h1>
        @if(session('success'))
            <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create Category</a>
        <table class="min-w-max w-full table-auto mt-4">
            <thead class="bg-gray-100">
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light bg-white">
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $category->id }}</td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <img class="w-12 h-12 object-cover" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">{{ $category->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form class="inline-block" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
