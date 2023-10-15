<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::all();
        return view('admin.pos.investments.index', compact('investments'));
    }

    public function create()
    {
        return view('admin.pos.investments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $investment = new Investment([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        // Set the created_at date
        $investment->created_at = Carbon::parse($request->date);  // Set to the specified date

        $investment->save();

        return redirect()->route('investments.index')->with('success', 'Investment added successfully.');
    }

}
