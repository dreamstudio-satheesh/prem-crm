@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="leadList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Lead List (ALT + T)</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('leads.create') }}" class="btn btn-sm btn-info" accesskey="C" title="ALT+C">
                            <i class="ri-file-add-line align-bottom me-1"></i> Add New Lead
                        </a>
                        <!-- Additional buttons for import/export if needed -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table class="table align-middle" id="leadTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Lead ID</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Follow Up Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->date->format('d/m/Y') }}</td>
                                <td>{{ $lead->product->name }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $lead->amount }}</td>
                                <td>{{ $lead->status }}</td>
                                <td>{{ $lead->follow_up_date->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-info">
                                        <i class="ri-edit-line align-bottom me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="ri-delete-bin-line align-bottom me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $leads->links() }} <!-- Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
