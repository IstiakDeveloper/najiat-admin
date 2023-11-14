@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mb-8">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Financial Overview</h2>
        <div class="flex mb-4 justify-between ">
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
                    <button class="bg-blue-500 hover:bg-blue-700 text-white mb-4 font-bold py-2 px-4 rounded">
                        <i class="fa fa-list"></i> Accounts
                    </button>
                </a>
            </div>
            <div class="buy-sell">
                <a href="{{route('buy-transactions.create')}}" class="mr-4">
                    <button class="bg-green-500 hover:bg-green-700 text-white mb-4 font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-up-long"></i> Buy
                    </button>
                </a>
                <a href="{{route('sell-transactions.create')}}" class="mr-4">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-down-long"></i> Sell
                    </button>
                </a>
            </div>

        </div>

        <form action="{{ route('financial-overview.index') }}" method="GET" class="flex items-center mb-4">
            <label class="mr-4">Filter:</label>
            <select name="filter" id="filter" class="mr-2 rounded-md border px-2 py-1">
                <option value="" disabled selected>Select Filter</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last_7_days">Last 7 Days</option>
                <option value="custom">Custom Date</option>
            </select>

            <div id="customDateInputs" class="hidden flex items-center">
                <label for="start_date" class="mr-2">Start Date:</label>
                <input type="date" name="start_date" class="rounded-md border px-2 py-1">

                <label for="end_date" class="mr-2 ml-4">End Date:</label>
                <input type="date" name="end_date" class="rounded-md border px-2 py-1">
            </div>

            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Investments Section -->
            <div class="bg-blue-200 border border-blue-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-blue-800">Total Investments</h3>
                    <i class="fas fa-chart-line text-2xl text-blue-800"></i>
                </div>
                <p class="text-3xl font-bold text-blue-800">{{ $totalInvestments }}</p>
                <ul>
                    @php
                      $lastFiveInvestments = $investments->sortByDesc('created_at')->take(5);
                   @endphp
                    @foreach ($lastFiveInvestments as $investment)
                        <li class="text-blue-800">{{ $investment->description }}: {{ $investment->amount }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Total Expenses Section -->
            <div class="bg-red-200 border border-red-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-red-800">Total Expenses</h3>
                    <i class="fas fa-chart-pie text-2xl text-red-800"></i>
                </div>
                <p class="text-3xl font-bold text-red-800">{{ $totalExpenses }}</p>
                <ul>
                    @php
                      $lastFiveExpenses = $expenses->sortByDesc('created_at')->take(5);
                   @endphp
                    @foreach ($lastFiveExpenses as $expense)
                        <li class="text-red-800">{{ $expense->description }}: {{ $expense->amount }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Total Account Balances Section -->
            <div class="bg-green-200 border border-green-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-green-800">Total Account Balances</h3>
                    <i class="fas fa-chart-bar text-2xl text-green-800"></i>
                </div>
                <p class="text-3xl font-bold text-green-800">{{ $totalBalance }}</p>
                <ul>
                    @php
                      $lastFiveAccounts = $accounts->sortByDesc('created_at')->take(5);
                   @endphp
                    @foreach ($lastFiveAccounts as $account)
                        <li class="text-green-800">{{ $account->name }}: {{ $account->balance }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Buy Amount Section -->
            <div class="bg-blue-200 border border-blue-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-blue-800">Total Buy</h3>
                    <i class="fas fa-chart-bar text-2xl text-blue-800"></i>
                </div>
                <p class="text-3xl font-bold text-blue-800">{{ $totalBuy }}</p>
                <ul>
                    @php
                      $todayBuy = $buy_transactions->sortByDesc('created_at')->take(3);
                   @endphp
                    @foreach ($todayBuy as $buy)
                        <li class="text-green-800">{{ $buy->from }}: {{ $buy->amount }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Sell Amount Section -->
            <div class="bg-red-200 border border-red-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-red-800">Total Sell</h3>
                    <i class="fas fa-chart-bar text-2xl text-red-800"></i>
                </div>
                <p class="text-3xl font-bold text-red-800">{{$totalSell}}</p>
                <ul>
                    @php
                      $todaySell = $sell_transactions->sortByDesc('created_at')->take(3);
                   @endphp
                    @foreach ($todaySell as $sell)
                        <li class="text-green-800">{{ $sell->from }}: {{ $sell->amount }}</li>
                    @endforeach
                </ul>
            </div>


             <!-- Total Account Balances Section -->
             <div class="bg-yellow-200 border border-yellow-400 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-xl font-bold text-yellow-800">Net Profit</h3>
                    <i class="fas fa-chart-bar text-2xl text-yellow-800"></i>
                </div>
                <p class="text-3xl font-bold text-yellow-800">{{ $totalProfit }}</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Financial Overview Chart</h2>
        <canvas id="financial-chart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = {!! $chartData !!};

    const ctx = document.getElementById('financial-chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // Function to toggle visibility of custom date inputs based on selection
    function toggleCustomDateInputs() {
        const customDateInputs = document.getElementById('customDateInputs');
        const filterSelect = document.getElementById('filter');

        if (filterSelect.value === 'custom') {
            customDateInputs.classList.remove('hidden');
        } else {
            customDateInputs.classList.add('hidden');
        }
    }

    // Add event listener to toggle custom date inputs on selection change
    document.getElementById('filter').addEventListener('change', toggleCustomDateInputs);

    // Toggle initially based on the selected value
    toggleCustomDateInputs();
</script>

@endsection
