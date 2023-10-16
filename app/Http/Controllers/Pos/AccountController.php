<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('admin.pos.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.pos.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
        ]);

        $account = new Account([
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        // Set the created_at date
        $account->created_at = Carbon::parse($request->date);  // Set to the current date and time

        $account->save();

        return redirect()->route('accounts.index')->with('success', 'Account added successfully.');
    }

    public function recharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'account_id' => 'required|exists:accounts,id',
            'source_account_id' => 'required|exists:accounts,id',
        ]);

        $rechargeAmount = $request->amount;
        $targetAccountId = $request->account_id;
        $sourceAccountId = $request->source_account_id; // The account from which to transfer

        $sourceAccount = Account::findOrFail($sourceAccountId);

        // Ensure the source account has sufficient balance for the transfer
        if ($sourceAccount->balance >= $rechargeAmount) {
            // Update the source account's balance (decrease)
            $sourceAccount->balance -= $rechargeAmount;
            $sourceAccount->save();

            // Update the target account's balance (increase)
            $targetAccount = Account::findOrFail($targetAccountId);
            $targetAccount->balance += $rechargeAmount;
            $targetAccount->save();

            Session::flash('success', 'Account recharged successfully.');
        } else {
            Session::flash('error', 'Insufficient balance in the source account.');
        }

        return redirect()->route('accounts.index');
    }






}
