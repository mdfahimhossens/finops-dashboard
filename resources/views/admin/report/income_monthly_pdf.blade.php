<h3>Monthly Income Report</h3>
<p><strong>From:</strong> {{ $from }} | <strong>To:</strong> {{ $to }}</p>
<p><strong>Total Income:</strong> {{ number_format($totalIncome,2) }}</p>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Month</th>
            <th>Income Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $i => $label)
        <tr>
            <td>{{ $label }}</td>
            <td>{{ number_format($incomeData[$i],2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if(!empty($barChart))
    <br><br>
    <img src="{{ $barChart }}" style="width:100%;">
@endif
@if(!empty($pieChart))
    <br><br>
    <img src="{{ $pieChart }}" style="width:100%;">
@endif