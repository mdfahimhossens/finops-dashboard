@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>All Expense Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/expense/add')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>Add Expense</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped table-hover custom_table">
                                  <thead class="table-dark">
                                    <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Category</th>
                                      <th>Amount</th>
                                      <th>Note</th>
                                      <th>Date</th>
                                      <th>Manage</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($all as $key => $row)
                                    <tr>
                                      <td>{{$key + 1}}</td>
                                      <td>{{$row->expense_name}}</td>
                                      <td>{{$row->CategoryInfo->expencate_name ?? 'N\A'}}</td>
                                      <td>{{number_format($row->expense_amount, 2)}}</td>
                                      <td>{{$row->expense_note}}</td>
                                      <td>{{date('d M y', strtotime($row->expense_date))}}</td>
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/view/'.$row->expense_slug)}}">View</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/edit/'.$row->expense_slug)}}">Edit</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/expense/softdelete/'.$row->expense_id)}}">Delete</a></li>
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