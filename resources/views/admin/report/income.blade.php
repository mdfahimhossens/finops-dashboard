@extends('layouts.admin')
@section('page')

<div class="row">
    <div class="col-md-12">

        <!-- Date-wise Filter -->
        <div class="card mb-3">
            <div class="card-header"><strong>Date-wise Income Report</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.report.income.filter') }}">
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
                            <button type="submit" class="btn btn-dark mt-2">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.report.income.pdf') }}">
    @csrf
    <input type="hidden" name="from_date" value="{{ old('from_date', $from ?? '') }}">
    <input type="hidden" name="to_date" value="{{ old('to_date', $to ?? '') }}">
    <button type="submit" class="btn btn-danger mb-3">
        <i class="fas fa-file-pdf"></i> Download PDF
    </button>
</form>

        @if(isset($incomes))
        <div class="card mt-3">
            <div class="card-body">
                <h5>Total Income: <strong>{{ number_format($totalIncome, 2) }}</strong></h5>

                <!-- Table -->
                <table id="myTable" class="table table-bordered mt-2">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Amount</th>
                            <th class="text-end">Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $key => $income)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ date('d M Y', strtotime($income->income_date)) }}</td>
                            <td>{{ $income->income_name }}</td>
                            <td>{{ $income->CategoryInfo->incate_name ?? 'N/A' }}</td>
                            <td>{{ number_format($income->income_salary, 2) }}</td>
                            <td class="text-end">{{ $income->income_office }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bar Chart -->
                <canvas id="incomeChart" width="400" height="150"></canvas>
            </div>
        </div>
        @endif

       
@if(isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Date-wise Bar Chart
    const ctx = document.getElementById('incomeChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                label: 'Income Amount',
                data: {!! json_encode($chartData->values()) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endif

@endsection
