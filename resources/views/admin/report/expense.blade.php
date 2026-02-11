@extends('layouts.admin')
@section('page')

<div class="row">
    <div class="col-md-12">

        <!-- Filter Card -->
        <div class="card mb-3">
            <div class="card-header"><strong>Date-wise Expense Report</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.report.expense.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ old('from_date', $from ?? '') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ old('to_date', $to ?? '') }}" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button class="btn btn-dark mt-2">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($expenses) && count($expenses))

        <div class="card">
            <div class="card-body">

                <h5>Total Expense: <strong>{{ number_format($totalExpense, 2) }}</strong></h5>

                <!-- Expense Table -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $key => $expense)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ date('d M Y', strtotime($expense->expense_date)) }}</td>
                            <td>{{ $expense->expense_name }}</td>
                            <td>{{ $expense->CategoryInfo->expencate_name ?? 'N/A' }}</td>
                            <td>{{ number_format($expense->expense_amount, 2) }}</td>
                            <td>{{ $expense->expense_note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                <!-- Charts -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <h6>Date-wise Expense</h6>
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h6>Category-wise Expense</h6>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

                <!-- Download PDF -->
                <form method="POST" action="{{ route('dashboard.report.expense.pdf') }}" id="pdfForm" class="mt-3">
                    @csrf
                    <input type="hidden" name="chart_image" id="chart_image">
                    <input type="hidden" name="pie_chart_image" id="pie_chart_image">
                    <input type="hidden" name="from" value="{{ $from }}">
                    <input type="hidden" name="to" value="{{ $to }}">
                    <input type="hidden" name="expenseData" value="{{ implode(',', $chartValues->toArray()) }}">
                    <input type="hidden" name="labels" value="{{ implode(',', $chartLabels->toArray()) }}">
                    <button class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                </form>

            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(isset($chartData))
<script>
/* BAR CHART */
const barCtx = document.getElementById('barChart');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartData->keys()) !!},
        datasets: [{
            label: 'Expense Amount',
            data: {!! json_encode($chartData->values()) !!},
            backgroundColor: '#0d6efd'
        }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});

/* PIE CHART */
@if(isset($pieChartData) && count($pieChartData))
const pieCtx = document.getElementById('pieChart');
const pieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($pieChartData->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($pieChartData->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', '#198754', '#ffc107',
                '#dc3545', '#6f42c1', '#20c997'
            ]
        }]
    },
    options: { responsive: true }
});
@endif

// Capture charts for PDF
document.getElementById('pdfForm').addEventListener('submit', function () {
    document.getElementById('chart_image').value = barChart.toBase64Image();
    document.getElementById('pie_chart_image').value = pieChart.toBase64Image();
});
</script>
@endif
@endsection
