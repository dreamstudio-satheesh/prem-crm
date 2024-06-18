@extends('layouts.admin')

@section('pagetitle','Customer - Master')
     

@section('content') 
 



<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Customer List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Customer</button>
                            <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom-dashed border-bottom">
                <form>
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for customer, email, phone, status or something..." wire:model="search">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="">
                                        <input type="text" class="form-control flatpickr-input" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div>
                                        <select class="form-control" wire:model="status">
                                            <option value="all">All</option>
                                            <option value="active">Active</option>
                                            <option value="block">Block</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div>
                                        <button type="button" class="btn btn-primary w-100" wire:click="filterData"> <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option" wire:model="selectAll">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="customer_name">Customer</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="phone">Phone</th>
                                    <th class="sort" data-sort="company_name">Company Name</th>
                                    <th class="sort" data-sort="status">Status</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($customers as $customer)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $customer->id }}" wire:model="selected">
                                        </div>
                                    </th>
                                    <td class="customer_name">{{ $customer->customer_name }}</td>
                                    <td class="email">{{ $customer->email_id }}</td>
                                    <td class="phone">{{ $customer->primaryContact->phones->first()->phone_number ?? '' }}</td>
                                    <td class="company_name">{{ $customer->company_name }}</td>
                                    <td class="status"><span class="badge badge-soft-{{ $customer->status == 'active' ? 'success' : 'danger' }} text-uppercase">{{ $customer->status }}</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn" wire:click="edit({{ $customer->customer_id }})">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" wire:click="confirmDelete({{ $customer->customer_id }})">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ customer We did not find any customer for you search.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $customers->links() }}
                    </div>
                </div>
                {{ $editMode="True"}}
                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $editMode ? 'Edit Customer' : 'Add Customer' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="tablelist-form" wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" autocomplete="off">
                                <div class="modal-body">
                                    <input type="hidden" id="id-field" wire:model="customerId">

                                    <div class="text-center">
                                                                    <div class="position-relative d-inline-block">
                                                                        <div class="position-absolute bottom-0 end-0">
                                                                            <label for="company-logo-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                                                <div class="avatar-xs cursor-pointer">
                                                                                    <div class="avatar-title bg-light border rounded-circle text-muted">
                                                                                        <i class="ri-image-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                            <input class="form-control d-none" value="" id="company-logo-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                        </div>
                                                                        <div class="avatar-lg p-1">
                                                                            <div class="avatar-title bg-light rounded-circle">
                                                                                <img src="{{ url('/themes/material/assets/images/users/multi-user.jpg') }}" id="companylogo-img" class="avatar-md rounded-circle object-cover" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="fs-13 mt-3">Company Logo</h5>
                                                                </div>

                                    <div class="mb-3">
                                        <label for="customername-field" class="form-label">Customer Name</label>
                                        <input type="text" id="customername-field" class="form-control" placeholder="Enter name" wire:model="customer_name" required>
                                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email-field" class="form-label">Email</label>
                                        <input type="email" id="email-field" class="form-control" placeholder="Enter email" wire:model="email_id" required>
                                        @error('email_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone-field" class="form-label">Phone</label>
                                        <input type="text" id="phone-field" class="form-control" placeholder="Enter phone no." wire:model="phone" required>
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="company-field" class="form-label">Company Name</label>
                                        <input type="text" id="company-field" class="form-control" placeholder="Enter company name" wire:model="company_name" required>
                                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div>
                                        <label for="status-field" class="form-label">Status</label>
                                        <select class="form-control" id="status-field" wire:model="status" required>
                                            <option value="">Status</option>
                                            <option value="active">Active</option>
                                            <option value="block">Block</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="modal-footer" style="display: block;">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">{{ $editMode ? 'Update' : 'Add' }} Customer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn w-sm btn-danger" wire:click="delete">Yes, Delete It!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('closeModal', () => {
            var myModalEl = document.getElementById('showModal');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();

            var backdrop = document.querySelector('.modal-backdrop.fade.show');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        });

        Livewire.on('showDeleteModal', () => {
            var myModalEl = document.getElementById('deleteRecordModal');
            var modal = new bootstrap.Modal(myModalEl);
            modal.show();
        });

        Livewire.on('closeDeleteModal', () => {
            var myModalEl = document.getElementById('deleteRecordModal');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();

            var backdrop = document.querySelector('.modal-backdrop.fade.show');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        });

        Livewire.hook('message.processed', (message, component) => {
            flatpickr('#company-field');
        });
    });
</script>
@endpush
@endsection