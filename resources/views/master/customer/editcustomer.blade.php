@extends('layouts.admin')

@section('pagetitle','Customer - Master-Edit')


@section('content')




<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">



            <div class="col-md-12 col-lg-10">
                <div class="card" style="height: 80vh; overflow-y: auto;">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h5> Add Customer</h5>
                    </div>


                    <div class="card-body" style="padding-top: 10px">
                        <form name="customeraddition" action="{{ route('customers.savecustomer') }}" 
                             method="post" class="form-horizontal form-bordered">
                            @csrf
                            
                            @foreach( $rscustomer as $customer)
                                   
                              @endforeach

                            <div class="form-group">
                                <label for="name">Customer Name*</label>
                                <input type="text" class="form-control" id="name" 
                                 name="name"   value='{{ $customer->customer_name }}' placeholder="Enter Customer Name">

                                 <input type="hidden" class="form-control" id="id" 
                                 name="id"   value='{{ $customer->customer_id }}' readonly>
                                @error('name') 
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                            <label for="product_id">Product</label>
                            <select class="form-control" id="product_id" name="product_id">
                                <option value="">Select Product</option>
                                @foreach($products as $rsproduct) 
                                    <option value="{{ $rsproduct->id }}"
                                    {{ $rsproduct->id== $customer->product_id ? 'selected' : ''}}>
                                    {{ $rsproduct->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
 
                        

                            <div class="form-group"> 
                                 <label for ="amc" class="form-label">A.M.C. </label>
                                 <select class="form-control" id="amc" name="amc"  >
                                     <option value="yes"  {{ $customer->amc =="yes" ? 'selected' : ''}}>YES</option>
                                     <option value="no"   {{ $customer->amc =="no" ? 'selected' : ''}}>NO</option>
                                 </select>
                                 @error('amc') 
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>

                            <div class="form-group"> 
                                 <label for ="amc" class="form-label">T.S.S. Status </label>
                                 <select class="form-control" id="tssstatus" name="tssstatus"  >
                                     <option value="active"  {{ $customer->tss_status =="active" ? 'selected' : ''}}>ACTIVE</option>
                                     <option value="inactive"  {{ $customer->tss_status =="inactive" ? 'selected' : ''}}>IN ACTIVE</option>
                                 </select>
                                 @error('amc') 
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            </div>
 
                            <div class="form-group">
                                <label for="tssdate">T.S.S. Expiry Date</label>
                                <input type="date"
                                value='{{ $customer->tss_expirydate }}'  class="form-control" id="tssdate"  name="tssdate" autofocus placeholder="Enter T.S.S. Expiry Date">
                                @error('tssdate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tssadminemail">T.S.S. Admin E-Mail</label>
                                <input type="text" class="form-control"
                                value='{{ $customer->tss_adminemail }}'  id="tssadminemail" name="tssadminemail" 
                                 placeholder="Enter T.S.S Admin Email">
                                @error('tssadminemail')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="profilestatus">Profile Status</label>
                                <select class="form-control" id="profilestatus"   name="profilestatus">
                                     <option value="Followup" {{ $customer->profile_status =="Followup" ? 'selected' : ''}}>FOLLOW UP</option>
                                     <option value="Others" {{ $customer->profile_status =="Others" ? 'selected' : ''}}>OTHERS</option>
                                 </select>
                                @error('profilestatus')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="executive_id">Followup Executive</label>
                                <select class="form-control" id="executive_id"  name="executive_id">
                                <option value="">Select Executive</option>
                                @foreach($user as $rsuser) 
                                    <option value="{{ $rsuser->id }}"
                                    {{ $rsuser->id== $customer->staff_id ? 'selected' : ''}}>
                                    {{ $rsuser->name }}</option>
                                @endforeach
                            </select>
                                @error('executive_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" value='{{ $customer->remarks }}' id="remarks" name="remarks" autofocus placeholder="Enter Remarks">
                                @error('remarks')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" click="create" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>













        </div>
    </div>
</div>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


@endpush
@endsection