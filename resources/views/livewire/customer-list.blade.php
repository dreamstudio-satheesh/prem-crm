<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Customer List (ALT + T )</h5>
                        </div>
                        <div class="col-sm-auto">
                            <button accesskey="S" title="ALT+S" wire:click="toggleFilters" class="btn btn-sm btn-secondary">
                                <i class="ri-filter-line align-bottom me-1"></i> {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
                            </button>

                            <a href="{{ route('customer_import.show') }}" class="btn btn-sm btn-info">
                                <i class="ri-file-download-line align-bottom me-1"></i> Import
                            </a>
                            <button wire:click="export" class="btn btn-sm btn-success">
                                <i class="ri-file-upload-line align-bottom me-1"></i> Export
                            </button>
                            <a href="{{ route('customers.add') }}" accesskey="C" title="ALT+C" class="btn btn-sm btn-info">
                                <i class="ri-file-add-line align-bottom me-1"></i> Add New
                            </a>
                        </div>
                    </div>
                </div>

                @if ($showFilters)
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <input type="date" wire:model.lazy="start_date" class="form-control" placeholder="Start Date">
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <input type="date" wire:model.lazy="end_date" class="form-control" placeholder="End Date">
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="amc">
                                    <option value="">Select AMC</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="license_edition">
                                    <option value="">Select License Edition</option>
                                    @foreach($license_editions as $edition)
                                    <option value="{{ $edition->id }}">{{ $edition->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="product">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="tss_status">
                                    <option value="">Select TSS Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="auto_backup">
                                    <option value="">Select Auto Backup</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="cloud_user">
                                    <option value="">Select Cloud User</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="mobile_app">
                                    <option value="">Select Mobile App</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="whatsapp">
                                    <option value="">Select WhatsApp</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select class="form-control form-control-sm" wire:model.lazy="status">
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-xxl-4 col-sm-6">
                                <div class="search-box">
                                    <input type="text" id="search-input" class="form-control form-control-sm search" placeholder="Search ..." wire:model.live.debounce.500ms="search">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

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
                                    <th>Tally S.NO</th>
                                    <th>A.M.C</th>
                                    <th>T.S.S</th>
                                    <th>Status</th>
                                    <th>Contact No</th>
                                    <th>Action</th>
                                    <th>Edit</th>
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
                                    <td>{{ $customer->tally_serial_no }}</td>
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
                                    <td>
                                        <span class="text-capitalize">{{ $customer->status }}</span>
                                    </td>
                                    <td>
                                        <span class="text-capitalize">{{ $customer->primaryMobileNumber->mobile_no ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-edit-line align-bottom me-1"></i> Customer
                                        </a>
                                    </td>
                                    <td>
                                        @if($customer->address_books_count == 0)
                                        <a href="{{ url('/master/customers/add-address', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-add-line align-bottom me-1"></i>  Address
                                        </a>
                                        @else
                                        <a href="{{ url('/master/customers/edit-address', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-edit-line align-bottom me-1"></i> Address
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


    @push('scripts')

    <script>
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

        document.addEventListener('livewire:init', () => {
            Livewire.on('filterToggled', () => {
                setTimeout(() => {
                    const searchInput = document.getElementById('search-input');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }, 100); // Delay by 100ms
            });
        });
    </script>
    @endpush
</div>