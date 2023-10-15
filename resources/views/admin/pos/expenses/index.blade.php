@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Expenses</h2>
    <div class="flex mb-4">
        <a href="{{ route('investments.index') }}" class="mr-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa fa-list"></i> Investments
            </button>
        </a>
        <a href="{{ route('expenses.index') }}" class="mr-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa fa-list"></i> Expenses
            </button>
        </a>
        <a href="{{ route('accounts.index') }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa fa-list"></i> Accounts
            </button>
        </a>
    </div>
    <table class="min-w-full border border-collapse my-4 px-4 bg-white">
        <thead>
            <tr>
                <th class="py-2 border-b">Date</th>
                <th class="py-2 border-b">Description</th>
                <th class="py-2 border-b">Amount</th>
                <th class="py-2 border-b">Account</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
            <tr>
                <td class="py-2 text-center border-b">{{ $expense->created_at->format('d-m-Y') }}</td>
                <td class="py-2 text-center border-b">{{ $expense->description }}</td>
                <td class="py-2 text-center border-b">{{ $expense->amount }}</td>
                <td class="py-2 text-center border-b">{{ $expense->account->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('expenses.create') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        <i class="fa fa-plus"></i> Add Expense
    </a>
</div>
@endsection
