@extends('layouts.admin')
@section('page')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Error Message --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>Report Information
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table class="table table-bordered table-striped table-hover custom_table">
                                  <thead class="table-dark">
                                    <tr>
                                      <th>Name</th>
                                      <th>Manager</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Report List:-</td>
                                      <td>
                                        <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">List item</button>
                                        <ul class="dropdown-menu">

                                            {{-- Income Reports --}}
                                            <li>
                                                <h6 class="dropdown-header">Income Reports</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('dashboard/report/income') }}">
                                                    Date-wise Income Report
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('dashboard/report/income/monthly') }}">
                                                    Monthly Income Report
                                                </a>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            {{-- Expense Reports --}}
                                            <li>
                                                <h6 class="dropdown-header">Expense Reports</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('dashboard/report/expense') }}">
                                                    Date-wise Expense Report
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('dashboard/report/expense/monthly') }}">
                                                    Monthly Expense Report
                                                </a>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            {{-- Financial Reports --}}
                                            <li>
                                                <h6 class="dropdown-header text-danger">Financial Summary</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item fw-bold text-success"
                                                  href="{{ url('dashboard/report/profit-loss') }}">
                                                    Profit / Loss Report
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item fw-bold text-primary"
                                                  href="{{ url('dashboard/report/profit-loss/monthly') }}">
                                                    Monthly Profit / Loss
                                                </a>
                                            </li>

                                        </ul>

                                          </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>  
                            </div>
                        </div>
                    </div>

                    
  @endsection   