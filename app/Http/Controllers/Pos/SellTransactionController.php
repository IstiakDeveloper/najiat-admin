<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SellTransaction;
use Illuminate\Http\Request;

class SellTransactionController extends Controller
{
    public function create()
    {
        $accounts = Account::all();
        return view('admin.pos.sell.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $account = Account::findOrFail($request->account_id);

        // Deduct the amount from the selected account
        $account->balance += $request->amount;
        $account->save();

        // Check if 'Pending Amount' account exists, create if it doesn't
        $pendingAmountAccount = Account::where('name', 'Pending Amount')->first();
        if (!$pendingAmountAccount) {
            $pendingAmountAccount = Account::create([
                'name' => 'Pending Amount',
                'balance' => 0,
            ]);
        }

        // Add the amount to the 'Pending Amount' account
        $pendingAmountAccount->balance -= $request->amount;
        $pendingAmountAccount->save();

        // Create a sell transaction
        SellTransaction::create([
            'account_id' => $request->account_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('financial-overview.index')->with('success', 'Sell transaction completed successfully.');
    }


}
