@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Lead</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('leads.update', $lead->id) }}">
                    @csrf
                    @method('PUT')

                    
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-control" id="customer_id" name="customer_id" required>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"  {{ $lead->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $lead->date->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $lead->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ $lead->amount }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="{{ $lead->status }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="follow_up_date" class="form-label">Follow Up Date</label>
                        <input type="date" class="form-control" id="follow_up_date" name="follow_up_date" value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
