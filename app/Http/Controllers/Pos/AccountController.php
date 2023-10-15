<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
