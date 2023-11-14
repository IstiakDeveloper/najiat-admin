<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('admin.pos.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('admin.pos.expenses.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'account_id' => 'required|exists:accounts,id',
        ]);

        // Fetch the selected account
        $account = Account::findOrFail($request->account_id);

        // Check if the account has sufficient balance for the expense
        if ($account->balance < $request->amount) {
            return redirect()->route('expenses.create')->with('error', 'Insufficient balance for the expense.');
        }

        // Deduct the expense amount from the account's balance
        $account->balance -= $request->amount;
        $account->save();

        // Create a new expense record
        $expense = new Expense([
            'description' => $request->description,
            'amount' => $request->amount,
            'account_id' => $request->account_id,
        ]);

        // Set the created_at date
        $expense->created_at = Carbon::parse($request->date);  // Set to the current date and time

        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

}
