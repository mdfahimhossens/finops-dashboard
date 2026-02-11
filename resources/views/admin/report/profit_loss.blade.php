@extends('layouts.admin')
@section('page')

<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">

            {{-- Card Header --}}
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Profit / Loss Report
            </div>

            {{-- Date Filter --}}
            <div class="card-body">
                <form method="POST" action="{{ url('dashboard/report/profit-loss') }}" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="date" name="from_date" class="form-control" value="{{ $from }}">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="to_date" class="form-control" value="{{ $to }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>

                {{-- Summary Cards --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5>Total Income</h5>
                                <h3>{{ number_format($totalIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-danger mb-3">
                            <div class="card-body">
                                <h5>Total Expense</h5>
                                <h3>{{ number_format($totalExpense, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card {{ $profitLoss >= 0 ? 'text-bg-success' : 'text-bg-danger' }} mb-3">
                            <div class="card-body">
                                <h5>Net {{ $status }}</h5>
                                <h3>{{ number_format($profitLoss, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="card-footer">
                <div class="btn-group" role="group">
                    <a href="{{ url('dashboard/report/profit-loss/print') }}" target="_blank" class="btn btn-sm btn-dark">Print</a>
                    <a href="{{ url('dashboard/report/profit-loss/pdf') }}" class="btn btn-sm btn-secondary">PDF</a>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
