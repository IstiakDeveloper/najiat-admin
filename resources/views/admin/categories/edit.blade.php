@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Edit Category</h1>
        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md" value="{{ old('name', $category->name) }}">
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Category Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="mt-1">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update Category</button>
        </form>
    </div>
@endsection
