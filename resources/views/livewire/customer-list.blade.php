<div>
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
                <div class="card-body">
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th>Customer</th>
                                    <th>A.M.C</th>
                                    <th>T.S.S</th>
                                    <th>Executive</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                    <th>Edit Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $customer->customer_id }}">
                                            </div>
                                        </th>
                                        <td class="text-uppercase">{{ $customer->customer_name }}</td>
                                        <td>
                                            <span class="badge badge-soft-{{ $customer->amc == 'yes' ? 'success' : 'danger' }} text-uppercase">
                                                {{ $customer->amc }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-{{ $customer->tss_status == 'active' ? 'success' : 'danger' }} text-uppercase">
                                                {{ $customer->tss_status }}
                                            </span>
                                        </td>
                                        <td>{{ $customer->staffname }}</td>
                                        <td>
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
                        <div class="d-flex justify-content-end">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
