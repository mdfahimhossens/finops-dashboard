<h3>Income Report</h3>
<p><strong>From:</strong> {{ $from }} | <strong>To:</strong> {{ $to }}</p>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Name</th>
            <th>Position</th>
            <th>Amount</th>
            <th>Office</th>
        </tr>
    </thead>
    <tbody>
        @foreach($incomes as $key => $income)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ date('d M Y', strtotime($income->income_date)) }}</td>
            <td>{{ $income->income_name }}</td>
            <td>{{ $income->CategoryInfo->incate_name ?? 'N/A' }}</td>
            <td>{{ number_format($income->income_salary,2) }}</td>
            <td>{{ $income->income_office }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"><strong>Total Income</strong></td>
            <td colspan="2"><strong>{{ number_format($totalIncome,2) }}</strong></td>
        </tr>
    </tbody>
</table>
