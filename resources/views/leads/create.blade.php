@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Lead</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Customer -->
                            <div class="col-md-4 mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Date -->
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <!-- Product -->
                            <div class="col-md-4 mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Amount -->
                            <div class="col-md-4 mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount">
                            </div>
                            <!-- Referral Name -->
                            <div class="col-md-4 mb-3">
                                <label for="referral_name" class="form-label">Referral Name</label>
                                <input type="text" class="form-control" id="referral_name" name="referral_name">
                            </div>
                            <!-- Referral Contact No -->
                            <div class="col-md-4 mb-3">
                                <label for="referral_contact_no" class="form-label">Referral Contact No</label>
                                <input type="text" class="form-control" id="referral_contact_no" name="referral_contact_no">
                            </div>
                            <!-- Follow Up Date -->
                            <div class="col-md-4 mb-3">
                                <label for="follow_up_date" class="form-label">Follow Up Date</label>
                                <input type="date" class="form-control" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
