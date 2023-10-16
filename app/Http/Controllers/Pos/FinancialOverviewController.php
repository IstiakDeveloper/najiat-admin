<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BuyTransaction;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\SellTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialOverviewController extends Controller
{
    public function index()
    {
        // Fetch investments, expenses, and account balances
        $investments = Investment::all();
        $expenses = Expense::all();
        $accounts = Account::all();
        $buy_transactions = BuyTransaction::all();
        $sell_transactions = SellTransaction::all();

        // Calculate total investments and total expenses
        $totalInvestments = $investments->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $totalBalance = $accounts->sum('balance');
        $totalBuy = $buy_transactions->sum('amount');
        $totalSell = $sell_transactions->sum('amount');
        $totalProfit = $totalBalance - $totalInvestments;

        $currentYear = Carbon::now()->year;

        // Fetch investment amounts for each month of the current year
        $investmentAmounts = Investment::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->get()
        ->pluck('total_amount', 'month');

        // Fetch expense amounts for each month of the current year
        $expenseAmounts = Expense::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->get()
        ->pluck('total_amount', 'month');

        // Assuming you have months
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $investmentData = [];
        $expenseData = [];

        foreach ($months as $index => $month) {
        $investmentData[] = $investmentAmounts[$index + 1] ?? 0; // Adding 1 to the index because months start from 1
        $expenseData[] = $expenseAmounts[$index + 1] ?? 0;
        }

        $chartData = [
        'labels' => $months,
        'datasets' => [
            [
                'label' => 'Investments',
                'data' => $investmentData,
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Expenses',
                'data' => $expenseData,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1,
            ],
        ],
        ];

        // Return the financial overview view with data
        return view('admin.pos.overview.index', [
            'totalInvestments' => $totalInvestments,
            'totalExpenses' => $totalExpenses,
            'totalBalance' => $totalBalance,
            'chartData' => json_encode($chartData),
            'accounts' => $accounts,
            'expenses' => $expenses,
            'investments' => $investments,
            'totalProfit' => $totalProfit,
            'buy_transactions' => $buy_transactions,
            'sell_transactions' => $sell_transactions,
            'totalBuy' => $totalBuy,
            'totalSell' => $totalSell,
        ]);
    }

    public function indexWithFilter(Request $request)
    {
        $filter = $request->input('filter');
        $startDate = null;
        $endDate = null;

        if ($filter === 'today') {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($filter === 'yesterday') {
            $startDate = Carbon::yesterday()->startOfDay();
            $endDate = Carbon::yesterday()->endOfDay();
        } elseif ($filter === 'last_7_days') {
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($filter === 'custom') {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        }

        // Fetch investments, expenses, and account balances for the selected date range
        $investments = Investment::whereBetween('created_at', [$startDate, $endDate])->get();
        $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])->get();
        $accounts = Account::whereBetween('created_at', [$startDate, $endDate])->get();
        $buy_transactions = BuyTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
        $sell_transactions = SellTransaction::whereBetween('created_at', [$startDate, $endDate])->get();

        // Calculate total investments and total expenses
        $totalInvestments = $investments->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $totalBalance = $accounts->sum('balance');
        $totalBuy = $buy_transactions->sum('amount');
        $totalSell = $sell_transactions->sum('amount');
        $totalProfit = $totalBalance - $totalInvestments;

        // Fetch data for the chart based on the selected date range
        $chartData = $this->fetchChartData($startDate, $endDate);

        return view('admin.pos.overview.index', [
            'totalInvestments' => $totalInvestments,
            'totalExpenses' => $totalExpenses,
            'totalBalance' => $totalBalance,
            'chartData' => json_encode($chartData),
            'accounts' => $accounts,
            'expenses' => $expenses,
            'investments' => $investments,
            'totalBuy' => $totalBuy,
            'totalSell' => $totalSell,
            'buy_transactions' => $buy_transactions,
            'sell_transactions' => $sell_transactions,
            'totalProfit' => $totalProfit,
        ]);
    }



    private function fetchChartData($startDate, $endDate)
    {
        // Fetch investment amounts for each month of the selected date range
        $investmentAmounts = Investment::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->get()
            ->pluck('total_amount', 'month');

        // Fetch expense amounts for each month of the selected date range
        $expenseAmounts = Expense::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->get()
            ->pluck('total_amount', 'month');

        // Assuming you have months
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $investmentData = [];
        $expenseData = [];

        foreach ($months as $index => $month) {
            $investmentData[] = $investmentAmounts[$index + 1] ?? 0; // Adding 1 to the index because months start from 1
            $expenseData[] = $expenseAmounts[$index + 1] ?? 0;
        }

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Investments',
                    'data' => $investmentData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Expenses',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }


}
