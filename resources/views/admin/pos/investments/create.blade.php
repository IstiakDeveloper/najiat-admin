@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Add Investment</h2>
    <form action="{{ route('investments.store') }}" method="POST" class="max-w-md">
        @csrf
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description:</label>
            <input type="text" name="description" id="description" class="form-input mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700">Amount:</label>
            <input type="number" name="amount" id="amount" class="form-input mt-1 block w-full px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700">Date:</label>
            <input type="date" name="date" id="date" class="form-input mt-1 block w-full px-4 py-2" value="{{ now()->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa fa-plus"></i> Add Investment
        </button>
    </form>
</div>
@endsection
