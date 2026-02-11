@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>All Income Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/income/add')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>Add Income</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped table-hover custom_table">
                                  <thead class="table-dark">
                                    <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Position</th>
                                      <th>Office</th>
                                      <th>Age</th>
                                      <th>Salary</th>
                                      <th class="text-end">Started Date</th>
                                      <th>Manage</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($all as $key => $row)
                                    <tr>
                                      <td>{{$key + 1}}</td>
                                      <td>{{$row->income_name}}</td>
                                      <td>{{$row->CategoryInfo->incate_name ?? 'N/A'}}</td>
                                      <td>{{$row->income_office}}</td>
                                      <td>{{$row->income_age}}</td>
                                      <td>{{number_format($row->income_salary, 2)}}</td>
                                      <td class="text-end">{{date('d M y', strtotime($row->income_date))}}</td>
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/view/'. $row->income_slug)}}">View</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/edit/'. $row->income_slug)}}">Edit</a></li>
                                              <li><a class="dropdown-item" href="{{url('dashboard/income/softdelete/'. $row->income_id)}}">Delete</a></li>
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