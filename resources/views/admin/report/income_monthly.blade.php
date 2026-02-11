@extends('layouts.admin')
@section('page')
 <!-- Monthly Income Report -->
        <div class="card mt-4">
            <div class="card-header"><strong>Monthly Income Report</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.report.income.monthly') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" required value="{{ old('from_date', $from ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" required value="{{ old('to_date', $to ?? '') }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <button class="btn btn-dark mt-2">Generate</button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($monthlyIncomes) && count($monthlyIncomes))
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Month</th>
                            <th>Total Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyIncomes as $key => $row)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ date('F Y', strtotime($row->year.'-'.$row->month.'-01')) }}</td>
                            <td>{{ number_format($row->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bar Chart -->
    <canvas id="monthlyIncomeChart" height="120"></canvas>

    <!-- Pie Chart -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            <h5>Monthly Income Distribution</h5>
            <canvas id="monthlyIncomePieChart" height="150"></canvas>
        </div>
    </div>

    <!-- Download PDF -->
    <form method="POST" action="{{ route('dashboard.report.income.monthly.pdf') }}" id="pdfForm" class="mt-3">
        @csrf
        <input type="hidden" name="chart_image" id="chart_image">
        <input type="hidden" name="pie_chart_image" id="pie_chart_image">
        <input type="hidden" name="from" value="{{ $from }}">
        <input type="hidden" name="to" value="{{ $to }}">
        <input type="hidden" name="incomeData" value="{{ implode(',', $chartValues) }}">
        <input type="hidden" name="labels" value="{{ implode(',', $chartLabels) }}">
        <button class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
    </form>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(isset($chartLabels))
<script>
const barCtx = document.getElementById('monthlyIncomeChart');
const monthlyBarChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Monthly Income',
            data: {!! json_encode($chartValues) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});

const pieCtx = document.getElementById('monthlyIncomePieChart');
const monthlyPieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            data: {!! json_encode($chartValues) !!},
            backgroundColor: [
                '#FF6384','#36A2EB','#FFCE56','#4BC0C0',
                '#9966FF','#FF9F40','#2ecc71','#e74c3c'
            ]
        }]
    },
    options: { responsive: true }
});

// Capture bar chart image for PDF
document.getElementById('pdfForm').addEventListener('submit', function () {
    document.getElementById('chart_image').value =
        monthlyBarChart.toBase64Image();
    document.getElementById('pie_chart_image').value =
        monthlyPieChart.toBase64Image();
});

</script>
@endif
@endsection