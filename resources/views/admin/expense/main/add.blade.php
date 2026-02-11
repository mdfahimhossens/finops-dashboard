@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12 ">
                            <form method="post" action="{{url('dashboard/expense/store')}}">
                                @csrf  
                              <div class="card mb-3">
                                  <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8 col-8 card_title_part">
                                            <i class="fab fa-gg-circle"></i>Expense Registration
                                        </div>  
                                        <div class="col-md-4 col-4 card_button_part">
                                            <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Expense</a>
                                        </div>  
                                    </div>
                                  </div>
                                  <div class="card-body">
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">User Name<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" name="exp_name" value="{{old('exp_name')}}">
                                         @if($errors->has('exp_name'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('exp_name') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        @php 
                                          $categories = App\Models\ExpenseCategory::where('expencate_status', 1)->orderBy('expencate_name', 'ASC')->get();
                                        @endphp
                                        <label class="col-sm-3 col-form-label col_form_label">Category<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <select name="exp_category" class="form-control form_control" value="{{old('exp_category')}}">
                                          <option value="">Selete Your Category</option>
                                          @foreach($categories as $category)   
                                          <option value="{{ $category->expencate_id }}">{{$category->expencate_name}}</option>
                                          @endforeach
                                          </select>
                                          @if($errors->has('exp_category'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('exp_category') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Amount<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" name="exp_amount" value="{{old('exp_amount')}}">
                                         @if($errors->has('exp_amount'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('exp_amount') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Note<span class="req_star"></span>:</label>
                                        <div class="col-sm-7">
                                          <textarea type="text" rows="4" cols="50" class="form-control form_control" name="exp_note" value="{{old('exp_note')}}"> </textarea>
                                         @if($errors->has('exp_note'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('exp_note') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Date<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="date" class="form-control form_control" name="exp_date" value="{{old('exp_date')}}">
                                         @if($errors->has('exp_date'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('exp_date') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                  </div>
                                  <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-sm btn-dark">Add</button>
                                  </div>  
                                </div>
                            </form>
                        </div>
                    </div>
@endsection