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

                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="ri-file-download-line align-bottom me-1"></i> Import
                            </button>
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
                                        <span class="text-capitalize">908899889</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-edit-line align-bottom me-1"></i> Edit Customer
                                        </a>
                                    </td>
                                    <td>
                                        @if($customer->address_books_count == 0)
                                        <a href="{{ url('/master/customers/add-address', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-add-line align-bottom me-1"></i> Create Address
                                        </a>
                                        @else
                                        <a href="{{ url('/master/customers/edit-address', $customer->customer_id) }}" class="btn btn-info">
                                            <i class="ri-edit-line align-bottom me-1"></i> Edit Address
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
        <div class="modal-dialog full-screen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">{{ $previewData ? 'Preview Customers' : 'Import Customers' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Import Modal Content -->
                <div class="modal-body">
                    @if ($previewData)
                    <table class="table">
                        <thead>
                            <tr>
                                @foreach($headers as $header)
                                <th>
                                    {{ $header }}
                                    <select wire:model="mappings.{{ $header }}">
                                        <option value="">Select Field</option>
                                        @foreach($columnOptions as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($previewData as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button wire:click="confirmImport" class="btn btn-success">Confirm Import</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    @else
                    <!-- File Upload Form -->
                    <form id="importForm" wire:submit.prevent="uploadAndPrepareImport">
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <input type="file" class="form-control" id="file" wire:model="upload_file">
                            @error('upload_file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Prepare Import</button>
                    </form>
                    @endif
                </div>

                @if ($previewData)
                <div class="modal-footer">
                    <button wire:click="confirmImport" class="btn btn-success">Confirm Import</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                @endif
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