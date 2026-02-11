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

@php
  $data = App\Models\Expense::where('expense_status', 0)->orderBy('expense_id', 'DESC')->get();
@endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>Recycle Main Expense Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>All Expense</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table class="table table-bordered table-striped table-hover custom_table">
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
                                    @foreach($data as $key => $row)
                                    <tr>
                                      <td>{{ $key + 1 }}</td>
                                      <td>{{ $row->expense_name }}</td>
                                      <td>{{ $row->CategoryInfo->expencate_name ?? 'N/A'}}</td>
                                      <td>{{number_format($row->expense_amount, 2)}}</td>
                                      <td>{{$row->expense_note}}</td>
                                      <td>{{date('d M y', strtotime($row->expense_date))}}</td>
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                              <!-- Restore Button -->
                                      <button type="button" class="btn btn-success btn-sm me-3" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#restoreModal{{ $row->expense_id }}">
                                          <i class="fa fa-recycle fs-5"></i>
                                      </button>

                                      <!-- Permanent Delete Button -->
                                      <button type="button" class="btn btn-danger btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#deleteModal{{ $row->expense_id }}">
                                          <i class="fa fa-trash fs-5"></i>
                                      </button>
                                          </div>
                                      </td>
                                      </tr>

                                      <!-- Restore Modal -->
                              <div class="modal fade" id="restoreModal{{ $row->expense_id }}" tabindex="-1" aria-labelledby="restoreModalLabel{{ $row->expencate_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="restoreModalLabel{{ $row->expense_id }}">Restore Category</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to restore <strong>{{ $row->income_name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <a href="{{ route('dashboard.expense.restore', $row->expense_id) }}" class="btn btn-success">Yes, Restore</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Permanent Delete Modal -->
                              <div class="modal fade" id="deleteModal{{ $row->expense_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $row->expense_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel{{ $row->expense_id }}">Permanent Delete</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to permanently delete <strong>{{ $row->expense_name }}</strong>? This action cannot be undone.
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <a href="{{ route('dashboard.expense.permanentDelete', $row->expense_id)}}" class="btn btn-danger">Yes, Delete</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                      @endforeach
                                  </tbody>
                                </table>
                              </div>
     
                            </div>
                        </div>
                    </div>

                    
  @endsection   