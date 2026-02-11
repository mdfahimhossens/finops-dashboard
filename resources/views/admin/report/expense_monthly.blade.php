@extends('layouts.admin')
@section('page')

<div class="row">
    <div class="col-md-12">

        <!-- Filter -->
        <div class="card mb-3">
            <div class="card-header"><strong>Monthly Expense Report</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.report.expense.monthly') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <button class="btn btn-dark mt-2">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($monthlyExpenses))
        <div class="card">
            <div class="card-body">

                <!-- Table -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Month</th>
                            <th>Total Expense</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyExpenses as $key => $row)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ date('F Y', strtotime($row->year.'-'.$row->month.'-01')) }}</td>
                            <td>{{ number_format($row->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Chart -->
                <canvas id="monthlyChart" height="120"></canvas>
                <!-- Monthly Pie Chart -->
                <div class="row justify-content-center align-middle">
                    <div class="col-md-6">
                    <div class="mt-4">
                    <h5 class="mb-2 text-center">Monthly Expense Distribution</h5>
                    <canvas id="monthlyPieChart" height="150" width="150"></canvas>
                </div>
                    </div>
                </div>
                   <!-- Download PDF -->
                <form method="POST" action="{{ route('dashboard.report.expense.monthly.pdf') }}" id="pdfForm" class="mt-3">
                    @csrf
                    <input type="hidden" name="chart_image" id="chart_image">
                    <input type="hidden" name="from" value="{{ $from }}">
                    <input type="hidden" name="to" value="{{ $to }}">
                    <input type="hidden" name="expenseData" value="{{ implode(',', $chartValues ) }}">
                    <input type="hidden" name="labels" value="{{ implode(',', $chartLabels ) }}">
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
<script>
const ctx = document.getElementById('monthlyChart');
const barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels ?? []) !!},
        datasets: [{
            label: 'Monthly Expense',
            data: {!! json_encode($chartValues ?? []) !!},
            backgroundColor: 'rgba(255, 99, 132, 0.7)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

const pieCtx = document.getElementById('monthlyPieChart');

new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($chartLabels ?? []) !!},
        datasets: [{
            data: {!! json_encode($chartValues ?? []) !!},
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40',
                '#2ecc71',
                '#e74c3c'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});

// Capture charts for PDF
document.getElementById('pdfForm').addEventListener('submit', function () {
    document.getElementById('chart_image').value = barChart.toBase64Image();
});

</script>
@endsection
