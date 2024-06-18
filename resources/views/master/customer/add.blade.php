@extends('layouts.admin')

@section('pagetitle','Customer - Master')
     

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
                <form  name="customeraddition" action="{{ url('submit.form') }}"
                           method="post" class="form-horizontal form-bordered"> 
                    
                        <div class="form-group">
                            <label for="name">Customer Name*</label>
                            <input type="text" class="form-control" id="name" autofocus placeholder="Enter Customer Name"  >
                            @error('name')
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