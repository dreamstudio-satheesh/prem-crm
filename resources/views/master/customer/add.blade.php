@extends('layouts.admin')

@section('pagetitle','Customer - Master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Add Customer</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form name="customeraddition" action="{{ route('customers.store') }}" method="post" class="form-horizontal form-bordered">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="name">Customer Name*</label>
                                <input type="text" class="form-control" id="name" name="name" autofocus placeholder="Enter Customer Name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select class="form-control" id="product_id" name="product_id">
                                    <option value="">Select Product</option>
                                    @foreach($products as $rsproduct)
                                    <option value="{{ $rsproduct->id }}">{{ $rsproduct->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="amc" class="form-label">A.M.C.</label>
                                <select class="form-control" id="amc" name="amc">
                                    <option value="yes">YES</option>
                                    <option value="no">NO</option>
                                </select>
                                @error('amc')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="tss_status" class="form-label">T.S.S. Status</label>
                                <select class="form-control" id="tss_status" name="tss_status">
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                </select>
                                @error('tss_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="tss_expirydate">T.S.S. Expiry Date</label>
                                <input type="date" class="form-control" id="tss_expirydate" name="tss_expirydate" placeholder="Enter T.S.S. Expiry Date">
                                @error('tss_expirydate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="tss_adminemail">T.S.S. Admin E-Mail</label>
                                <input type="email" class="form-control" id="tss_adminemail" name="tss_adminemail" placeholder="Enter T.S.S Admin Email">
                                @error('tss_adminemail')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="profile_status">Profile Status</label>
                                <select class="form-control" id="profile_status" name="profile_status">
                                    <option value="Followup">FOLLOW UP</option>
                                    <option value="Others">OTHERS</option>
                                </select>
                                @error('profile_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="executive_id">Followup Executive</label>
                                <select class="form-control" id="executive_id" name="executive_id">
                                    <option value="">Select Executive</option>
                                    @foreach($users as $rsuser)
                                    <option value="{{ $rsuser->id }}">{{ $rsuser->name }}</option>
                                    @endforeach
                                </select>
                                @error('executive_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks">
                                @error('remarks')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="form-group gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
