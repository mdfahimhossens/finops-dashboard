@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12 ">
                            <form method="post" action="{{url('dashboard/expense/update')}}">
                              @csrf
                                <div class="card mb-3">
                                  <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8 col-8 card_title_part">
                                            <i class="fab fa-gg-circle"></i>Update Expense Information
                                        </div>  
                                        <div class="col-md-4 col-4 card_button_part">
                                            <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Expense</a>
                                        </div>  
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <input type="hidden" id="" name="id" value="{{$data->expense_id}}">
                                    <input type="hidden" id="" name="slug" value="{{$data->expense_slug}}">
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">User Name<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" id="" name="exp_name" value="{{$data->expense_name}}">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        @php 
                                          $categories = App\Models\ExpenseCategory::where('expencate_status', 1)->orderBy('expencate_name', 'ASC')->get();
                                        @endphp
                                        <label class="col-sm-3 col-form-label col_form_label">Expense Category<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <select name="exp_category" class="form-control form_control" value="{{old('expense_category')}}">
                                          <option value="">Selete Your Category</option>
                                          @foreach($categories as $category)   
                                          <option value="{{ $category->expencate_id }}" 
                                          {{old('exp_category', $data->expencate_id) == $category->expencate_id ? 'selected' : ''}}>{{$category->expencate_name}}</option>
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
                                          <input type="text" class="form-control form_control" id="" name="exp_amount" value="{{$data->expense_amount}}">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Expense Note<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                         <textarea type="text" rows="4" cols="50" class="form-control form_control" name="exp_note" value="{{$data->expense_note}}">{{$data->expense_note}}</textarea>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Expense Date<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" id="" name="exp_date" value="{{$data->expense_date}}">
                                        </div>
                                      </div>

                                  </div>
                                  <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-sm btn-dark">UPDATE</button>
                                  </div>  
                                </div>
                            </form>
                        </div>
                    </div>
    @endsection