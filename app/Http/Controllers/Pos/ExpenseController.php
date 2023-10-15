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
