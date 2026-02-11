@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12 ">
                            <form method="post" action="{{url('dashboard/expense/category/submit')}}">
                                @csrf  
                              <div class="card mb-3">
                                  <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8 col-8 card_title_part">
                                            <i class="fab fa-gg-circle"></i>Expense Category Registration
                                        </div>  
                                        <div class="col-md-4 col-4 card_button_part">
                                            <a href="{{url('dashboard/expense/category')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Category</a>
                                        </div>  
                                    </div>
                                  </div>
                                  
                                  <div class="card-body">
                                  <div class="row mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                                  <label class="col-sm-3 col-form-label col_form_label">Expense Category Name<span class="req_star">*</span>:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control form_control" id="" name="name" value="{{old('expencate_name')}}">
                                    @if($errors->has('name'))
                                      <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                    @endif
                                  </div>
                                </div>
                               <div class="row mb-3 {{ $errors->has('remarks') ? ' has-error' : '' }}">
                                  <label class="col-sm-3 col-form-label col_form_label">Remarks:<span class="req_star">*</span>:</label>
                                  <div class="col-sm-7">
                                    <input type="text" class="form-control form_control" id="" name="remarks" value="{{old('expencate_remarks')}}">
                                    @if($errors->has('remarks'))
                                      <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                      </span>
                                    @endif
                                  </div>
                                </div>
                                  </div>
                                  <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-sm btn-dark">REGISTRATION</button>
                                  </div>  
                                </div>
                            </form>
                        </div>
                    </div>
@endsection