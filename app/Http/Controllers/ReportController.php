<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Expense;
use App\Models\income;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class ReportController extends Controller
{

public function incomeReport() {
        $from = null;
    $to = null;
    return view('admin.report.income');
}

public function incomeReportFilter(Request $request){
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);

    $from = $request->from_date;
    $to = $request->to_date;

    $incomes = Income::where('income_status', 1)->whereBetween('income_date', [$from, $to])
    ->orderBy('income_date', 'ASC')->get();

    $totalIncome = $incomes->sum('income_salary');

    // Prepare chart data
        $chartData = $incomes->groupBy(function($item){
            return $item->income_date;
        })->map(function($row){
            return $row->sum('income_salary');
        });

    return view('admin.report.income', compact('incomes', 'totalIncome', 'from', 'to', 'chartData'));
}

public function incomeReportPdf(Request $request) {
    $from = $request->from_date;
    $to   = $request->to_date;

    $incomes = Income::where('income_status', 1)
        ->whereBetween('income_date', [$from, $to])
        ->orderBy('income_date', 'ASC')->get();

    $totalIncome = $incomes->sum('income_salary');

    $pdf = Pdf::loadView('admin.report.income_pdf', [
        'incomes' => $incomes,
        'totalIncome' => $totalIncome,
        'from' => $from,
        'to' => $to
    ]);

    return $pdf->download('income-report.pdf');
}

// Monthly Income Report (View + Chart)
public function monthlyIncomeReport(Request $request)
{
    $monthlyIncomes = [];
    $chartLabels = [];
    $chartValues = [];
    $from = null;
    $to = null;

    if ($request->isMethod('post')) {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        $from = $request->from_date;
        $to   = $request->to_date;

        $monthlyIncomes = DB::table('incomes')
            ->selectRaw('YEAR(income_date) as year, MONTH(income_date) as month, SUM(income_salary) as total')
            ->where('income_status', 1)
            ->whereBetween('income_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        foreach ($monthlyIncomes as $row) {
            $chartLabels[] = date('F Y', strtotime($row->year.'-'.$row->month.'-01'));
            $chartValues[] = $row->total;
        }
    }

    return view('admin.report.income_monthly', compact(
        'monthlyIncomes',
        'chartLabels',
        'chartValues',
        'from',
        'to'
    ));
}

public function monthlyIncomePdf(Request $request)
{
    $incomeData = array_map('floatval', explode(',', $request->incomeData));
    $totalIncome = array_sum($incomeData);

    return Pdf::loadView('admin.report.income_monthly_pdf', [
        'from'        => $request->from,
        'to'          => $request->to,
        'labels'      => explode(',', $request->labels),
        'incomeData'  => $incomeData,
        'totalIncome' => $totalIncome,
        'barChart' => $request->chart_image,
        'pieChart' => $request->pie_chart_image,
    ])->download('monthly-income-report.pdf');
}

  public function monthlyExpenseReport(Request $request)
{
    $monthlyExpenses = [];
    $chartLabels = [];
    $chartValues = [];
    $from = null;
    $to = null;

    if ($request->isMethod('post')) {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $from = $request->from_date;
        $to = $request->to_date;

        // Monthly grouped query
        $monthlyExpenses = DB::table('expenses')
            ->select(
                DB::raw('YEAR(expense_date) as year'),
                DB::raw('MONTH(expense_date) as month'),
                DB::raw('SUM(expense_amount) as total')
            )
            ->where('expense_status', 1)
            ->whereBetween('expense_date', [$from, $to])
            ->groupBy('year','month')
            ->orderBy('year','ASC')
            ->orderBy('month','ASC')
            ->get();

        // Chart data
        foreach ($monthlyExpenses as $row) {
            $chartLabels[] = date('F Y', strtotime($row->year.'-'.$row->month.'-01'));
            $chartValues[] = $row->total;
        }

        return view('admin.report.expense_monthly', compact('monthlyExpenses','chartLabels','chartValues','from','to'));
    }
}

public function monthlyExpensePdf(Request $request){
    $expenseData = array_map('floatval', explode(',', $request->expenseData));
    $totalExpense = array_sum($expenseData);

    return Pdf::loadView('admin.report.expense_monthly_pdf', [
        'from'        => $request->from,
        'to'          => $request->to,
        'labels'      => explode(',', $request->labels),
        'expenseData'  => $expenseData,
        'totalExpense' => $totalExpense,
        'barChart' => $request->chart_image,
    ])->download('monthly-expense-report.pdf');
}

public function expense() {
    return view('admin.report.report');
  }

public function expenseReport() {
    return view('admin.report.expense');
  }

  public function expenseReportFilter(Request $request) {
        $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);

    $from = $request->from_date;
    $to   = $request->to_date;

    // Date-wise expense
    $expenses = Expense::with('CategoryInfo')
        ->where('expense_status', 1)
        ->whereBetween('expense_date', [$from, $to])
        ->orderBy('expense_date', 'ASC')
        ->get();

    $totalExpense = $expenses->sum('expense_amount');

    // For bar chart: date-wise sum
    $chartData = $expenses->groupBy(function($item){
        return $item->expense_date;
    })->map(function($row){
        return $row->sum('expense_amount');
    });

    // For pie chart: category-wise sum
    $pieChartData = $expenses->groupBy(function($item){
        return $item->CategoryInfo->expencate_name ?? 'N/A';
    })->map(function($row){
        return $row->sum('expense_amount');
    })->map(function($total, $name){
        return ['name'=>$name,'total'=>$total];
    });

    // Convert collections to arrays if needed for Blade PDF
    $chartValues = $chartData->values();
    $chartLabels = $chartData->keys();

    return view('admin.report.expense', compact(
        'expenses', 'totalExpense', 'chartData', 'pieChartData', 
        'chartValues', 'chartLabels', 'from', 'to'
    ));
}

  public function expenseReportPdf(Request $request) {
   $expenseData = array_map('floatval', explode(',', $request->expenseData));
        $totalExpense = array_sum($expenseData);
        $labels = explode(',', $request->labels);

        return Pdf::loadView('admin.report.expense_pdf', [
            'from'       => $request->from,
            'to'         => $request->to,
            'labels'     => $labels,
            'expenseData'=> $expenseData,
            'totalExpense' => $totalExpense,
            'barChart'   => $request->chart_image,
            'pieChart'   => $request->pie_chart_image
        ])->download('expense-report.pdf');
  }

        // Date-wise Profit/Loss
    public function profitLoss(Request $request)
    {
        $from = $request->from_date ?? now()->startOfMonth()->toDateString();
        $to   = $request->to_date ?? now()->toDateString();

        // Total Income
        $totalIncome = DB::table('incomes')
            ->whereBetween('income_date', [$from, $to])
            ->sum('income_salary');

        // Total Expense
        $totalExpense = DB::table('expenses')
            ->whereBetween('expense_date', [$from, $to])
            ->sum('expense_amount');

        // Profit / Loss
        $profitLoss = $totalIncome - $totalExpense;
        $status = $profitLoss >= 0 ? 'Profit' : 'Loss';

        return view('admin.report.profit_loss', compact(
            'from','to','totalIncome','totalExpense','profitLoss','status'
        ));
    }

    // Monthly Profit/Loss
    public function profitLossMonthly()
    {
        $monthlyIncome = DB::table('incomes')
            ->selectRaw('MONTH(income_date) as month, SUM(income_salary) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyExpense = DB::table('expenses')
            ->selectRaw('MONTH(expense_date) as month, SUM(expense_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $incomeData = [];
        $expenseData = [];
        $profitData = [];

        foreach ($monthlyIncome as $inc) {
            $months[] = date('F', mktime(0,0,0,$inc->month,1));
            $incomeData[] = $inc->total;

            $exp = $monthlyExpense->firstWhere('month', $inc->month)->total ?? 0;
            $expenseData[] = $exp;
            $profitData[] = $inc->total - $exp;
        }

        return view('admin.report.profit_loss_monthly', compact(
            'months','incomeData','expenseData','profitData'
        ));
    }

    private function getProfitLossData($request) {
    $from = $request->from_date ?? now()->startOfMonth()->toDateString();
    $to = $request->to_date ?? now()->toDateString();

    $totalIncome = DB::table('incomes')->whereBetween('income_date', [$from, $to])->sum('income_salary');
    $totalExpense = DB::table('expenses')->whereBetween('expense_date', [$from, $to])->sum('expense_amount');
    $profitLoss = $totalIncome - $totalExpense;
    $status = $profitLoss >= 0 ? 'Profit' : 'Loss';

    return compact('from','to','totalIncome','totalExpense','profitLoss','status');
}

    public function profitLossPrint(Request $request) {
        $data = $this->getProfitLossData($request);
        return view('admin.report.profit_loss_print', $data);
    }

    public function profitLossPdf(Request $request) {
        $data = $this->getProfitLossData($request);
        $pdf = Pdf::loadView('admin.report.profit_loss_print', $data);
        return $pdf->download('profit_loss_report.pdf');
    }

}
