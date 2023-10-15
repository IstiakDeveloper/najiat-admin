@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Add Account</h2>
    <form action="{{ route('accounts.store') }}" method="POST" class="max-w-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label for="balance" class="block text-gray-700">Balance:</label>
            <input type="number" name="balance" id="balance" class="form-input mt-1 block w-full px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700">Date:</label>
            <input type="date" name="date" id="date" class="form-input mt-1 block w-full px-4 py-2" value="{{ now()->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa fa-plus"></i> Add Account
        </button>
    </form>
</div>
@endsection
