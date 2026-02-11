<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // ===== Totals =====
    $totalUsers   = User::count();
    $totalIncome  = Income::where('income_status', 1)->sum('income_salary');
    $totalExpense = Expense::where('expense_status', 1)->sum('expense_amount');
    $profit       = $totalIncome - $totalExpense;

    // ===== This month & last month dates =====
    $thisMonthStart = now()->startOfMonth();
    $lastMonthStart = now()->subMonthNoOverflow()->startOfMonth();
    $lastMonthEnd   = now()->subMonthNoOverflow()->endOfMonth();

    // ===== This month income/expense/users =====
    $incomeThisMonth = Income::where('income_status', 1)
        ->whereBetween('income_date', [$thisMonthStart, now()])
        ->sum('income_salary');

    $incomeLastMonth = Income::where('income_status', 1)
        ->whereBetween('income_date', [$lastMonthStart, $lastMonthEnd])
        ->sum('income_salary');

    $expenseThisMonth = Expense::where('expense_status', 1)
        ->whereBetween('expense_date', [$thisMonthStart, now()])
        ->sum('expense_amount');

    $expenseLastMonth = Expense::where('expense_status', 1)
        ->whereBetween('expense_date', [$lastMonthStart, $lastMonthEnd])
        ->sum('expense_amount');

    $usersThisMonth = User::whereBetween('created_at', [$thisMonthStart, now()])->count();
    $usersLastMonth = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

    // ===== Percent helper =====
    $pct = function ($current, $prev) {
        if ($prev == 0) return $current > 0 ? 100 : 0;
        return round((($current - $prev) / $prev) * 100, 1);
    };

    $incomePct = $pct($incomeThisMonth, $incomeLastMonth);
    $expensePct = $pct($expenseThisMonth, $expenseLastMonth);
    $usersPct = $pct($usersThisMonth, $usersLastMonth);

    // ===== Monthly Income vs Expense (year) =====
    $incomeByMonth = Income::selectRaw('MONTH(income_date) month, SUM(income_salary) total')
        ->where('income_status', 1)
        ->whereYear('income_date', now()->year)
        ->groupBy('month')
        ->pluck('total', 'month');

    $expenseByMonth = Expense::selectRaw('MONTH(expense_date) month, SUM(expense_amount) total')
        ->where('expense_status', 1)
        ->whereYear('expense_date', now()->year)
        ->groupBy('month')
        ->pluck('total', 'month');

    $months = collect(range(1, 12));
    $labels = $months->map(fn($m) => Carbon::create()->month($m)->format('M'))->toArray();

    $incomeChart = $months->map(fn($m) => (float)($incomeByMonth[$m] ?? 0))->toArray();
    $expenseChart = $months->map(fn($m) => (float)($expenseByMonth[$m] ?? 0))->toArray();

    // ===== User join chart (monthly) =====
    $usersByMonth = User::selectRaw('MONTH(created_at) month, COUNT(*) total')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('total', 'month');

    $userJoinChart = $months->map(fn($m) => (int)($usersByMonth[$m] ?? 0))->toArray();

    // ===== Pie chart (Income vs Expense total) =====
    $pieLabels = ['Income', 'Expense'];
    $pieData   = [(float)$totalIncome, (float)$totalExpense];

    // ===== Expense category pie =====
    $expenseByCategory = Expense::selectRaw('expencate_id, SUM(expense_amount) total')
        ->where('expense_status', 1)
        ->groupBy('expencate_id')
        ->orderByDesc('total')
        ->take(6)
        ->get();

    $expCatLabels = $expenseByCategory->map(fn($r) => 'Cat#'.$r->expencate_id)->toArray();
    $expCatTotals = $expenseByCategory->pluck('total')->map(fn($v)=>(float)$v)->toArray();

    // ===== Sparklines (last 10 days) =====
    $days = collect(range(9, 0))->map(fn($i) => now()->subDays($i)->toDateString());

    $incomeSpark = $days->map(function($d){
        return (float) Income::where('income_status', 1)
            ->whereDate('income_date', $d)
            ->sum('income_salary');
    })->toArray();

    $expenseSpark = $days->map(function($d){
        return (float) Expense::where('expense_status', 1)
            ->whereDate('expense_date', $d)
            ->sum('expense_amount');
    })->toArray();

    $usersSpark = $days->map(function($d){
        return (int) User::whereDate('created_at', $d)->count();
    })->toArray();

    // ===== Recent activity (Created + Updated) =====
    $latestUsersCreated = User::latest('created_at')->take(8)->get();
    $latestUsersUpdated = User::orderByDesc('updated_at')->take(8)->get();

    $latestIncomeCreated = Income::orderByDesc('created_at')->take(8)->get();
    $latestIncomeUpdated = Income::orderByDesc('updated_at')->take(8)->get();

    $latestExpenseCreated = Expense::orderByDesc('created_at')->take(8)->get();
    $latestExpenseUpdated = Expense::orderByDesc('updated_at')->take(8)->get();

    return view('admin.dashboard.home', compact(
        'totalUsers','totalIncome','totalExpense','profit',

        'incomeThisMonth','incomePct',
        'expenseThisMonth','expensePct',
        'usersThisMonth','usersPct',

        'labels','incomeChart','expenseChart',
        'userJoinChart',

        'pieLabels','pieData',
        'expCatLabels','expCatTotals',

        'incomeSpark','expenseSpark','usersSpark',

        'latestUsersCreated','latestUsersUpdated',
        'latestIncomeCreated','latestIncomeUpdated',
        'latestExpenseCreated','latestExpenseUpdated'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
