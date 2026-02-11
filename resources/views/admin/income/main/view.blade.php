@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>View Main Income Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/income')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Income</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <table class="table table-bordered table-striped table-hover custom_view_table">
                                          <tr>
                                            <td>Name</td>  
                                            <td>:</td>  
                                            <td>{{$data->income_name}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Position</td>  
                                            <td>:</td>  
                                            <td>{{$data->CategoryInfo->incate_name ?? 'POSITION NOT APPLIED'}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Office</td>  
                                            <td>:</td>  
                                            <td>{{$data->income_office}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Age</td>  
                                            <td>:</td>  
                                            <td>{{$data->income_age}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Amount</td>  
                                            <td>:</td>  
                                            <td>{{$data->income_salary}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Income Date</td>  
                                            <td>:</td>  
                                            <td>{{$data->income_date}}</td>
                                          </tr>
                                            <tr>
                                            <td>Creator</td>  
                                            <td>:</td>  
                                            <td>{{$data->CreatorUser->name ?? 'User Deleted'}}</td>
                                          </tr>
                                            <tr>
                                            <td>Created Time</td>  
                                            <td>:</td>  
                                            <td>{{$data->created_at}}</td>
                                          </tr>
                                           <tr>
                                            <td>Editor</td>  
                                            <td>:</td>  
                                            <td>{{$data->EditorInfo->name ?? 'N/A'}}</td>
                                          </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                              </div>

                            </div>
                        </div>
                    </div>
@endsection