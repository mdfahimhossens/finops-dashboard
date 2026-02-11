@extends('layouts.admin')
@section('page')
                    <div class="row">
                        <div class="col-md-12 ">
                            <form method="post" action="{{url('dashboard/income/update')}}">
                              @csrf    
                            <div class="card mb-3">
                                  <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8 col-8 card_title_part">
                                            <i class="fab fa-gg-circle"></i>User Main Income Add
                                        </div>  
                                        <div class="col-md-4 col-4 card_button_part">
                                            <a href="{{url('dashboard/income')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Income</a>
                                        </div>  
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <input type="hidden" id="" name="id" value="{{$data->income_id}}">
                                    <input type="hidden" id="" name="slug" value="{{$data->income_slug}}">
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">User Name<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" name="inc_name" value="{{$data->income_name}}">
                                        </div>
                                      </div>
                                      @php 
                                        $categories = App\Models\IncomeCategory::where('incate_status', 1)->orderBy('incate_name', 'ASC')->get();
                                      @endphp
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Income Category<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <select name="inc_position" class="form-control form_control" value="{{old('inc_position')}}">
                                          <option value="">Selete Your Category</option>
                                          @foreach($categories as $category)   
                                          <option value="{{ $category->incate_id }}" 
                                          {{old('inc_position', $data->incate_id) == $category->incate_id ? 'selected' : ''}}>{{$category->incate_name}}</option>
                                          @endforeach
                                          </select>
                                          @if($errors->has('inc_position'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('inc_position') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Income Office<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" name="inc_office" value="{{$data->income_office}}">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">User Age<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" id="" name="inc_age" value="{{$data->income_age}}">
                                          @if($errors->has('inc_age'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('inc_age') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Income Amout<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control form_control" id="" name="inc_salary" value="{{$data->income_salary}}">
                                          @if($errors->has('inc_salary'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('inc_salary') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label col_form_label">Income Date<span class="req_star">*</span>:</label>
                                        <div class="col-sm-7">
                                          <input type="date" class="form-control form_control" id="" name="inc_date" value="{{$data->income_date}}">
                                          @if($errors->has('inc_date'))
                                        <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $errors->first('inc_date') }}</strong>
                                        </span>
                                          @endif
                                        </div>
                                      </div>
                                  </div>
                                  <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-sm btn-dark">Update</button>
                                  </div>  
                                </div>
                            </form>
                        </div>
                    </div>
@endsection