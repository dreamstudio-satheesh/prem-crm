@extends('layouts.admin')

@section('pagetitle', 'Customer - Master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Customer List</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('customers.add') }}" class="btn btn-info">
                            <i class="ri-file-download-line align-bottom me-1"></i> Add New Customer
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom-dashed border-bottom">
                <form>
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <div class="row g-3">
                                <!-- Additional search/filter fields can be added here if needed -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table class="table align-middle" id="customerTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                    </div>
                                </th>
                                <th class="sort" data-sort="customer_name">Customer</th>
                                <th class="sort" data-sort="amc">A.M.C</th>
                                <th class="sort" data-sort="tss_status">T.S.S</th>
                                <th class="sort" data-sort="executive">Executive</th>
                                <th class="sort" data-sort="remarks">Remarks</th>
                                <th>Action</th>
                                <th>Edit Address</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($customers as $customer)
                            <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $customer->customer_id }}">
                                    </div>
                                </th>
                                <td class="customer_name text-uppercase">{{ $customer->customer_name }}</td>
                                <td class="amc">
                                    <span class="badge badge-soft-{{ $customer->amc == 'yes' ? 'success' : 'danger' }} text-uppercase">
                                        {{ $customer->amc }}
                                    </span>
                                </td>
                                <td class="tss_status">
                                    <span class="badge badge-soft-{{ $customer->tss_status == 'active' ? 'success' : 'danger' }} text-uppercase">
                                        {{ $customer->tss_status }}
                                    </span>
                                </td>
                                <td class="executive">{{ $customer->staffname }}</td>
                                <td class="remarks">
                                    <span class="badge badge-soft text-uppercase">{{ $customer->remarks }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-info">
                                        <i class="ri-edit-line align-bottom me-1"></i> Edit Customer
                                    </a>
                                </td>
                                <td>
                                    @if($customer->address_books_count == 0)

                                    <a href="{{ url('/master/customers/add-address', $customer->customer_id) }}" class="btn btn-info">
                                        <i class="ri-add-line align-bottom me-1"></i> Create Address Book
                                    </a>

                                    @else
                                    <a href="{{ url('/master/customers/edit-address', $customer->customer_id) }}" class="btn btn-info">
                                        <i class="ri-edit-line align-bottom me-1"></i> Edit Address Book
                                    </a>

                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Sorry! No Result Found</h5>
                            <p class="text-muted mb-0">We've searched more than 150+ customers. We did not find any customer for your search.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('checkAll').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="chk_child"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    });
</script>
@endpush