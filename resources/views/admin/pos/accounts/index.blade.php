@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Accounts</h2>
    <div class="flex mb-4 justify-between">
        <div class="nav">
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

    </div>
    <table class="min-w-full border border-collapse my-4 px-4 bg-white">
        <thead>
            <tr>
                <th class="py-2 border-b">Date</th>
                <th class="py-2 border-b">Name</th>
                <th class="py-2 border-b">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
            <tr>
                <td class="py-2 text-center border-b">{{ $account->created_at->format('d-m-Y') }}</td>
                <td class="py-2 border-b text-center">{{ $account->name }}</td>
                <td class="py-2 border-b text-center">{{ $account->balance }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('accounts.create') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        <i class="fa fa-plus"></i> Add Account
    </a>
</div>
@endsection
