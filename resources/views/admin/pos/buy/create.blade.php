@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Create Buy Transaction</h2>
    <form action="{{ route('buy-transactions.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="account_id" class="block text-gray-700 text-sm font-bold mb-2">Select Account:</label>
            <select name="account_id" id="account_id" class="border rounded w-full py-2 px-3 text-gray-700">
                @foreach($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->name }}</option>
                @endforeach
            </select>
            @error('account_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
            <input type="number" name="amount" id="amount" class="border rounded w-full py-2 px-3 text-gray-700"
                placeholder="Enter the amount">
            @error('amount')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>
@endsection
