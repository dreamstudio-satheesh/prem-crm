@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 flex-grow-1">Edit Lead</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('leads.update', $lead->id) }}">
            @csrf
            @method('PUT')
            <!-- Add form fields based on the leads table -->
            <div class="form-group">
                <label for="customer_id">Customer ID:</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ $lead->customer_id }}">
            </div>
            <!-- Repeat for other fields -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
