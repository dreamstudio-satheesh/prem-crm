<!-- resources/views/livewire/contact-master.blade.php -->
<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header">
                    <div class="row" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-8">
                            <h2>Contact Master</h2>
                        </div>
                        <div class="col-md-4 text-right">
                            <input wire:model.debounce.300ms="search" id="search-box" type="text" class="form-control" placeholder="Search Contacts...">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="padding-top: 10px">
                        <table class="table table-bordered mt-5">
                            @if ($contacts->count() > 0)
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->company }}</td>
                                    <td>
                                        <button wire:click="edit({{ $contact->contact_id }})" class="btn btn-primary btn-sm">Edit</button>
                                        <button x-data="{ unitId: {{ $contact->contact_id }} }" @click="confirmDeletion(unitId)" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="6">
                                    <h5>No contacts found</h5>
                                </td>
                            </tr>
                            @endif
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>{{ $contacts->links() }}</div>
                            <div class="text-right">Total: {{ $contacts->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>{{ $contact_id ? 'Edit Contact' : 'Create Contact' }}</h5>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" autofocus placeholder="Enter contact name" wire:model="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone*</label>
                            <input type="text" class="form-control" placeholder="Enter phone number" wire:model="phone">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" wire:model="email">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Enter address" wire:model="address">
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" placeholder="Enter company" wire:model="company">
                            @error('company')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" placeholder="Enter notes" wire:model="notes"></textarea>
                            @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <select class="form-control" wire:model="designation">
                                <option value="">Select Designation</option>
                                <option value="MD">MD</option>
                                <option value="Auditor">Auditor</option>
                                <option value="GSTP / Tax Consultant">GSTP / Tax Consultant</option>
                                <option value="Computer Service">Computer Service</option>
                                <option value="Company Staff">Company Staff</option>
                                <option value="others">Others</option>
                            </select>
                            @error('designation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="selected_customers">Assign to Customers</label>
                            <select multiple class="form-control" wire:model="selected_customers">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('selected_customers')
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
                    Swal.fire('Deleted!', 'Contact Deleted Successfully.', 'success');
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
        });
    </script>
    @endpush
</div>
