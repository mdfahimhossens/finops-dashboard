<h3>Profit / Loss Report</h3>
<p>From: {{ $from }} To: {{ $to }}</p>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Total Income</th>
            <th>Total Expense</th>
            <th>Net {{ $status }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ number_format($totalIncome,2) }}</td>
            <td>{{ number_format($totalExpense,2) }}</td>
            <td>{{ number_format($profitLoss,2) }}</td>
        </tr>
    </tbody>
</table>
