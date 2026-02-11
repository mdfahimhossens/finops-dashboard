@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>View Expense Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Expense</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <table class="table table-bordered table-striped table-hover custom_view_table">
                                          <tr>
                                            <td>User Name</td>  
                                            <td>:</td>  
                                            <td>{{$data->expense_name}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Category</td>  
                                            <td>:</td>  
                                            <td>{{$data->expencate_id}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Amount</td>  
                                            <td>:</td>  
                                            <td>{{$data->expense_amount}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Note</td>  
                                            <td>:</td>  
                                            <td>{{$data->expense_note}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Date</td>  
                                            <td>:</td>  
                                            <td>{{$data->expense_date}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Creator</td>  
                                            <td>:</td>  
                                            <td>{{$data->creatorUser->name}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Created Time</td>  
                                            <td>:</td>  
                                            <td>{{$data->created_at}}</td>  
                                          </tr>
                                          <tr>
                                            <td>Editor</td>
                                            <td>:</td>
                                            <td>{{$data->editorUser->expense_editor ?? 'N\A'}}</td>
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