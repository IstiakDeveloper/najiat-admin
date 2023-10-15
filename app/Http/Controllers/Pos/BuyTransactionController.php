<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BuyTransaction;
use Illuminate\Http\Request;

class BuyTransactionController extends Controller
{
    public function create()
    {
        $accounts = Account::all();
        return view('admin.pos.buy.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $account = Account::findOrFail($request->account_id);

        // Deduct the amount from the selected account
        $account->balance -= $request->amount;
        $account->save();

        // Check if 'Pending Amount' account exists, create if not
        $pendingAccount = Account::firstOrNew(['name' => 'Pending Amount']);
        $pendingAccount->balance += $request->amount;
        $pendingAccount->save();

        // Create a buy transaction
        BuyTransaction::create([
            'account_id' => $request->account_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('financial-overview.index')->with('success', 'Buy transaction completed successfully.');
    }

}
