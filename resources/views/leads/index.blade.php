@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 flex-grow-1">All Leads</h4>
        <a href="{{ route('leads.create') }}" class="btn btn-primary">Add New Lead</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $lead)
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->customer_id }}</td> <!-- Update according to your needs -->
                    <td>{{ $lead->product_id }}</td> <!-- Update according to your needs -->
                    <td>{{ $lead->status }}</td>
                    <td>
                        <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-success">Edit</a>
                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
