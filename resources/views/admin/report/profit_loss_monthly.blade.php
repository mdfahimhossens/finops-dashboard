@extends('layouts.admin')
@section('page')

<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">

            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Monthly Profit / Loss
            </div>

            <div class="card-body">
                <canvas id="profitLossChart" height="100"></canvas>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('profitLossChart').getContext('2d');

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [
            {
                label: 'Income',
                data: @json($incomeData),
                backgroundColor: 'rgba(40, 167, 69, 0.7)'
            },
            {
                label: 'Expense',
                data: @json($expenseData),
                backgroundColor: 'rgba(220, 53, 69, 0.7)'
            },
            {
                label: 'Profit',
                data: @json($profitData),
                type: 'line',
                borderColor: 'rgba(0,0,0,0.9)',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Monthly Profit vs Expense' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
