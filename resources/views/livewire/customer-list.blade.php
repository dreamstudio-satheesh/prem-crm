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
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="ri-file-download-line align-bottom me-1"></i> Import 
                            </button>
                            <button wire:click="export" class="btn btn-sm btn-success">
                                <i class="ri-file-upload-line align-bottom me-1"></i> Export 
                            </button>
                            <a href="{{ route('customers.add') }}" class="btn btn-sm btn-info">
                                <i class="ri-file-add-line align-bottom me-1"></i> Add New 
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

    <!-- Import Modal -->
    <div class="modal fade" wire:ignore.self id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Customers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importForm" wire:submit.prevent="import">
                        <div class="form-group">
                            <label for="file">Upload CSV File</label>
                            <input type="file" class="form-control" id="file" wire:model="upload_file">
                            @error('upload_file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('close-modal', event => {
            var modal = $('#importModal');
            modal.modal('hide');
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-toastr', event => {
                toastr.options = {
                    closeButton: true,
                    positionClass: "toast-top-right",
                };
                const detail = event.detail[0];
                if (detail && detail.message) {
                    toastr.success(detail.message);
                }
            });
        });
    </script>
    @endpush
</div>
