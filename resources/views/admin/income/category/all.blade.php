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
                                        <i class="fab fa-gg-circle"></i>All Income Category Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/income/category/add')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>Add Category</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped table-hover custom_table">
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
                                      <td>{{ $row->incate_name }}</td>
                                      <td>{{ $row->incate_remarks }}</td>
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/category/view/'.$row->incate_slug)}}">View</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/category/edit/'.$row->incate_slug)}}">Edit</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/category/softdelete/'.$row->incate_id)}}">Delete</a></li>
                                            </ul>
                                          </div>
                                      </td>
                                      </tr>
                                      @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>
  @endsection   