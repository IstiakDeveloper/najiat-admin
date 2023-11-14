@extends('layouts.app')

@section('content')
<style>
    /* Style for the recharge button */
.recharge-button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 500px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

</style>
<div class="container mx-auto p-6">
    <h2 class="text-2xl mb-4">Accounts</h2>
    <div class="flex mb-4 justify-between">
        <div class="nav">
            <a href="{{ route('investments.index') }}" class="mr-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                    <i class="fa fa-list"></i> Investments
                </button>
            </a>
            <a href="{{ route('expenses.index') }}" class="mr-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                    <i class="fa fa-list"></i> Expenses
                </button>
            </a>
            <a href="{{ route('accounts.index') }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">
                    <i class="fa fa-list"></i> Accounts
                </button>
            </a>
        </div>
        <div>
            <button onclick="showRechargeModal()" class="recharge-button">Transfer</button>
        </div>

    </div>
    <table class="min-w-full border border-collapse my-4 px-4 bg-white">
        <thead>
            <tr>
                <th class="py-2 border-b">Date</th>
                <th class="py-2 border-b">Name</th>
                <th class="py-2 border-b">Balance</th>
                <th class="py-2 border-b">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
            <tr>
                <td class="py-2 text-center border-b">{{ $account->created_at->format('d-m-Y') }}</td>
                <td class="py-2 border-b text-center">{{ $account->name }}</td>
                <td class="py-2 border-b text-center">{{ $account->balance }}</td>
                <td class="py-2 border-b text-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="showUpdateBalanceModal({{ $account->id }}, {{ $account->balance }})">
                        Update Balance
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('accounts.create') }}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        <i class="fa fa-plus"></i> Add Account
    </a>
</div>


<!-- Recharge Modal -->
<div id="rechargeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRechargeModal()">&times;</span>
        <h2 class="text-center">Recharge Account</h2>

        <form id="rechargeForm" action="{{ route('accounts.recharge') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="rechargeSourceAccount">Source Account:</label>
                <select id="rechargeSourceAccount" name="source_account_id" class="form-control" required>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="rechargeTargetAccount">Select Account to Recharge:</label>
                <select id="rechargeTargetAccount" name="account_id" class="form-control" required>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="rechargeAmount">Recharge Amount:</label>
                <input type="number" id="rechargeAmount" name="amount" min="0" class="form-control" required>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Recharge</button>
        </form>

    </div>
</div>

<div id="updateBalanceModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!-- Modal title -->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Update Balance</p>
                <div onclick="closeUpdateBalanceModal()" class="modal-close cursor-pointer z-50">
                    <i class="fas fa-times text-red-600 hover:text-red-800"></i>
                </div>
            </div>

            <!-- Modal body -->
            <form id="updateBalanceForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="balance" class="block text-gray-700">New Balance:</label>
                    <input type="number" name="balance" id="balance" class="form-input mt-1 block w-full px-4 py-2" required value="{{ $account->balance }}">
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function showRechargeModal() {
        document.getElementById('rechargeModal').style.display = 'block';
    }

    function closeRechargeModal() {
        document.getElementById('rechargeModal').style.display = 'none';
    }

    function showUpdateBalanceModal(accountId, initialBalance) {
        // Set the account ID in the form action
        const form = document.getElementById('updateBalanceForm');
        form.action = `/accounts/${accountId}/save-balance`;

        // Update the balance input
        const balanceInput = document.getElementById('balance');
        balanceInput.value = initialBalance;

        // Show the modal
        const modal = document.getElementById('updateBalanceModal');
        modal.classList.remove('hidden');
    }


    function closeUpdateBalanceModal() {
        // Close the modal
        const modal = document.getElementById('updateBalanceModal');
        modal.classList.add('hidden');
    }

</script>

@endsection
