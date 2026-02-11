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
                                        <i class="fab fa-gg-circle"></i>All Expense Category Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/expense/category/add')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>Add Category</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table class="table table-bordered table-striped table-hover custom_table">
                                  <thead class="table-dark">
                                    <tr>
                                      <th>Name</th>
                                      <th>Remarks</th>
                                      <th>Manage</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($allData as $row)
                                    <tr>
                                      <td>{{$row->expencate_name}}</td>
                                      <td>{{$row->expencate_remarks}}</td>
                                     
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/category/view/'.$row->expencate_slug)}}">View</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/category/edit/'.$row->expencate_slug)}}">Edit</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/category/softdelete/'.$row->expencate_id)}}">Delete</a></li>
                                            </ul>
                                          </div>
                                      </td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                                </table>
                              </div>
                              <div class="card-footer">
                                <div class="btn-group" role="group" aria-label="Button group">
                                  <button type="button" class="btn btn-sm btn-dark">Print</button>
                                  <button type="button" class="btn btn-sm btn-secondary">PDF</button>
                                  <button type="button" class="btn btn-sm btn-dark">Excel</button>
                                </div>
                              </div>  
                            </div>
                        </div>
                    </div>
  @endsection   