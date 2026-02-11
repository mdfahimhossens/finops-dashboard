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
  $data = App\Models\IncomeCategory::where('incate_status', 0)->orderBy('incate_id', 'DESC')->get();
@endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3">
                              <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 col-8 card_title_part">
                                        <i class="fab fa-gg-circle"></i>Recycle Income Category Information
                                    </div>  
                                    <div class="col-md-4 col-4 card_button_part">
                                        <a href="{{url('dashboard/income/category')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>All Category</a>
                                    </div>  
                                </div>
                              </div>
                              <div class="card-body">
                                <table class="table table-bordered table-striped table-hover custom_table">
                                  <thead class="table-dark">
                                    <tr>
                                      <th>Name</th>
                                      <th>Remarks</th>
                                      <th>Manage</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($data as $row)
                                    <tr>
                                      <td>{{ $row->incate_name }}</td>
                                      <td>{{ $row->incate_remarks }}</td>
                                      <td>
                                          <div class="btn-group btn_group_manage" role="group">
                                              <!-- Restore Button -->
                    <button type="button" class="btn btn-success btn-sm me-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="#restoreModal{{ $row->incate_id }}">
                        <i class="fa fa-recycle fs-5"></i>
                    </button>

                    <!-- Permanent Delete Button -->
                    <button type="button" class="btn btn-danger btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal{{ $row->incate_id }}">
                        <i class="fa fa-trash fs-5"></i>
                    </button>
                                          </div>
                                      </td>
                                      </tr>

                                      <!-- Restore Modal -->
                              <div class="modal fade" id="restoreModal{{ $row->incate_id }}" tabindex="-1" aria-labelledby="restoreModalLabel{{ $row->incate_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="restoreModalLabel{{ $row->incate_id }}">Restore Category</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to restore <strong>{{ $row->incate_name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <a href="{{ route('dashboard.income.category.restore', $row->incate_id) }}" class="btn btn-success">Yes, Restore</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Permanent Delete Modal -->
                              <div class="modal fade" id="deleteModal{{ $row->incate_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $row->incate_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel{{ $row->incate_id }}">Permanent Delete</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to permanently delete <strong>{{ $row->incate_name }}</strong>? This action cannot be undone.
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <a href="{{ route('dashboard.income.category.permanentDelete', $row->incate_id)}}" class="btn btn-danger">Yes, Delete</a>
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