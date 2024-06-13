<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header">
                    <div class="row" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-8">
                            <h2>Customer Master</h2>
                        </div>
                        <div class="col-md-4 text-right">
                            <input wire:model.debounce.300ms="search" id="search-box" type="text" class="form-control" placeholder="Search Customers...">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="padding-top: 10px">
                        <table class="table table-bordered mt-5">
                            @if ($customers->count() > 0)
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th>Mobile Number</th>
                                    <th>Email ID</th>
                                    <th>Company Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->mobile_number }}</td>
                                    <td>{{ $customer->email_id }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td>
                                        <button wire:click="edit({{ $customer->customer_id }})" class="btn btn-primary btn-sm">Edit</button>
                                        <button x-data="{ unitId: {{ $customer->customer_id }} }" @click="confirmDeletion(unitId)" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="6">
                                    <h5>No customers found</h5>
                                </td>
                            </tr>
                            @endif
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>{{ $customers->links() }}</div>
                            <div class="text-right">Total: {{ $customers->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>{{ $customer_id ? 'Edit Customer' : 'Create Customer' }}</h5>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="customer_name">Customer Name*</label>
                            <input type="text" class="form-control" id="customer_name" autofocus placeholder="Enter customer name" wire:model="customer_name">
                            @error('customer_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number*</label>
                            <input type="text" class="form-control" placeholder="Enter mobile number" wire:model="mobile_number">
                            @error('mobile_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email_id">Email ID</label>
                            <input type="text" class="form-control" placeholder="Enter email ID" wire:model="email_id">
                            @error('email_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" placeholder="Enter company name" wire:model="company_name">
                            @error('company_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tally_no">Tally Serial No </label>
                            <input type="text" class="form-control" placeholder="Enter tally no" wire:model="tally_no">
                            @error('tally_no')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tally_version">Tally Version</label>
                            <input type="text" class="form-control" placeholder="Enter tally version" wire:model="tally_version">
                            @error('tally_version')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lat">Latitude</label>
                            <input type="number" step="0.000001" class="form-control" placeholder="Enter latitude" wire:model="lat">
                            @error('lat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lng">Longitude</label>
                            <input type="number" step="0.000001" class="form-control" placeholder="Enter longitude" wire:model="lng">
                            @error('lng')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" placeholder="Enter city" wire:model="city">
                            @error('city')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" placeholder="Enter address" wire:model="address"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <select class="form-control" wire:model="designation">
                                <option value="">Select Designation</option>
                                <option value="Owner">Owner</option>
                                <option value="Accounts Manager">Accounts Manager</option>
                                <option value="Accountant">Accountant</option>
                                <option value="Auditor">Auditor</option>
                                <option value="TAX Consultant">TAX Consultant</option>
                            </select>
                            @error('designation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                       
                     
                        <div class="form-group">
                            <label for="whatsapp_telegram_group">WhatsApp / Telegram Group</label>
                            <select class="form-control" wire:model="whatsapp_telegram_group">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('whatsapp_telegram_group')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                     
                        <div class="form-group gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" wire:click="create" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDeletion(unitId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', unitId);
                    Swal.fire('Deleted!', 'Customer Deleted Successfully.', 'success');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-toastr', event => {
                toastr.options = {
                    closeButton: true,
                    positionClass: "toast-top-right",
                };
                toastr.success(event.detail.message);
            });

          /*   hotkeys('alt+i', function(event, handler) {
                event.preventDefault();
                let customerName = document.getElementById('customer_name');
                if (document.activeElement !== customerName) {
                    customerName.focus();
                }
            }); */
            
        });
    </script>
    @endpush
</div>
