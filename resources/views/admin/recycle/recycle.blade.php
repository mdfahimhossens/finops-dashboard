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
                                        <i class="fab fa-gg-circle"></i>Recycle Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/income/category')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>All Category</a>
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
                                      <td>Recycle List:-</td>
                                      <td>
                                        <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">List item</button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{url('dashboard/recycle/income')}}">Income Main</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/recycle/income/category')}}">Income Category</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/recycle/expense')}}">Expense Main</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/recycle/expense/category')}}">Expense Category</a></li>
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