@extends('layouts.admin')
@section('page')

<style>
  .kpi-card{border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,.06); border:0;}
  .kpi-title{font-size:14px; color:#6c757d; margin:0;}
  .kpi-value{font-size:28px; font-weight:700; margin:6px 0 0;}
  .kpi-meta{font-size:13px; margin-top:6px;}
  .kpi-meta.up{color:#198754;}
  .kpi-meta.down{color:#dc3545;}
  .spark{height:44px;}
  .card_item{
    width: 100%;
    height: 160px;
    padding: 20px 15px 0px 20px;
  }
  .activity-box{
  max-height: 260px;
  overflow-y: auto;
}
.activity-item{
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}
.activity-title{font-weight:600;}
.activity-meta{font-size:12px;color:#6c757d;}
</style>

<div class="row g-3">

    {{-- Users --}}
  <div class="col-md-3 col-6">
    <div class="card kpi-card">
      <div class="card_item">
        <div class="kpi-head">
          <div>
            <p class="kpi-title">Users (This Month)</p>
            <div class="kpi-value">{{ number_format($usersThisMonth) }}</div>
            <div class="kpi-meta {{ $usersPct >= 0 ? 'up':'down' }}">
              {{ $usersPct >= 0 ? '▲':'▼' }} {{ abs($usersPct) }}%
            </div>
          </div>
          <div class="spark w-50">
            <canvas id="sparkUsers"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Income --}}
  <div class="col-md-3 col-6">
    <div class="card kpi-card">
      <div class="card_item">
        <div class="kpi-head">
          <div>
            <p class="kpi-title">Income (This Month)</p>
            <div class="kpi-value">৳ {{ number_format($incomeThisMonth) }}</div>
            <div class="kpi-meta {{ $incomePct >= 0 ? 'up':'down' }}">
              {{ $incomePct >= 0 ? '▲':'▼' }} {{ abs($incomePct) }}%
            </div>
          </div>
          <div class="spark w-50">
            <canvas id="sparkIncome"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Expense --}}
  <div class="col-md-3 col-6">
    <div class="card kpi-card">
      <div class="card_item">
        <div class="kpi-head">
          <div>
            <p class="kpi-title">Expense (This Month)</p>
            <div class="kpi-value">৳ {{ number_format($expenseThisMonth) }}</div>
            <div class="kpi-meta {{ $expensePct <= 0 ? 'up':'down' }}">
              {{-- expense increase is bad, so flip color logic if you want --}}
              {{ $expensePct >= 0 ? '▲':'▼' }} {{ abs($expensePct) }}%
            </div>
          </div>
          <div class="spark w-50">
            <canvas id="sparkExpense"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Profit/Loss --}}
  <div class="col-md-3 col-6">
    <div class="card kpi-card">
      <div class="card_item">
        <p class="kpi-title">Profit / Loss</p>
        <div class="kpi-value">৳ {{ number_format($profit) }}</div>
        <div class="kpi-meta {{ $profit >= 0 ? 'up':'down' }}">
          {{ $profit >= 0 ? 'Profit' : 'Loss' }}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><strong>Monthly Income vs Expense</strong></div>
            <div class="card-body">
                <canvas id="incomeExpenseChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><strong>User Join ({{ now()->year }})</strong></div>
            <div class="card-body">
                <canvas id="userJoinChart" height="140"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><strong>Recent Added</strong></div>
            <div class="card-body activity-box">
                @foreach($latestUsersCreated as $u)
                    <div class="activity-item">
                        <div class="activity-title">🆕 User Added: {{ $u->name }}</div>
                        <div class="activity-meta">{{ $u->created_at }}</div>
                    </div>
                @endforeach

                @foreach($latestIncomeCreated as $i)
                    <div class="activity-item">
                        <div class="activity-title">💰 Income Added: {{ $i->income_name }} — ৳{{ number_format($i->income_salary) }}</div>
                        <div class="activity-meta">{{ $i->created_at }}</div>
                    </div>
                @endforeach

                @foreach($latestExpenseCreated as $e)
                    <div class="activity-item">
                        <div class="activity-title">💸 Expense Added: {{ $e->expense_name }} — ৳{{ number_format($e->expense_amount) }}</div>
                        <div class="activity-meta">{{ $e->created_at }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><strong>Recent Updated</strong></div>
            <div class="card-body activity-box">
                @foreach($latestUsersUpdated as $u)
                    <div class="activity-item">
                        <div class="activity-title">✏️ User Updated: {{ $u->name }}</div>
                        <div class="activity-meta">{{ $u->updated_at }}</div>
                    </div>
                @endforeach

                @foreach($latestIncomeUpdated as $i)
                    <div class="activity-item">
                        <div class="activity-title">✏️ Income Updated: {{ $i->income_name }} — ৳{{ number_format($i->income_salary) }}</div>
                        <div class="activity-meta">{{ $i->updated_at }}</div>
                    </div>
                @endforeach

                @foreach($latestExpenseUpdated as $e)
                    <div class="activity-item">
                        <div class="activity-title">✏️ Expense Updated: {{ $e->expense_name }} — ৳{{ number_format($e->expense_amount) }}</div>
                        <div class="activity-meta">{{ $e->updated_at }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="copyright">
  <p style="color: #000;">© 2026 - Made with  by <a href="https://www.facebook.com/mdfahim.hossensujon" target="_blank">Fahim</a></p>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Data from controller
    const labels = @json($labels);
    const incomeData = @json($incomeChart);
    const expenseData = @json($expenseChart);

    const userJoinData = @json($userJoinChart);

    const pieLabels = @json($pieLabels);
    const pieData = @json($pieData);

    const expCatLabels = @json($expCatLabels);
    const expCatTotals = @json($expCatTotals);

    // 1) Monthly Income vs Expense (Bar)
    new Chart(document.getElementById('incomeExpenseChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Income', data: incomeData },
                { label: 'Expense', data: expenseData }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } }
        }
    });

    // 2) User Join Chart (Line)
    new Chart(document.getElementById('userJoinChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                { label: 'Users Joined', data: userJoinData, tension: 0.35 }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });

    // 3) Income vs Expense Pie
    new Chart(document.getElementById('incomeExpensePie'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{ data: pieData }]
        },
        options: { responsive: true }
    });

    // 4) Expense Category Pie
    new Chart(document.getElementById('expenseCategoryPie'), {
        type: 'doughnut',
        data: {
            labels: expCatLabels,
            datasets: [{ data: expCatTotals }]
        },
        options: { responsive: true }
    });
});
</script>



@endsection