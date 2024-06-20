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
                            <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
                            <button type="button"
                              onclick="location.href='{{ route('customers.add') }}'"
                            
                            class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Add New Customer</button>
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
                                        <button type="button" class="btn btn-primary w-100" wire:click="filterData"> 
                                            <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
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
                                    <th class="sort" data-sort="AMC">A.M.C</th>
                                    <th class="sort" data-sort="TSS">T.S.S</th>
                                    <th class="sort" data-sort="Executive">Executive</th>
                                    <th class="sort" data-sort="Remarks">Remarks</th>
                                    <th>Action</th>
                                    <th>Edit Address</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($customers as $customer)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input"  
                                            type="checkbox" name="chk_child" 
                                            value="{{ $customer->customer_id }}" >
                                        </div>
                                    </th>
                                    <td class="customer_name">
                                    <span class=" text-uppercase">{{ $customer->customer_name }}</span></td>
                            
        <td class="AMC"><span class="badge badge-soft-{{ $customer->amc == 'yes' ? 'success' : 'danger' }} text-uppercase">
        {{ $customer->amc }}</span></td>
        <td class="TSS"><span class="badge badge-soft-{{ $customer->tss_status == 'active' ? 'success' : 'danger' }} text-uppercase">
                                        {{ $customer->tss_status }}</span></td>
                                    <td class="Executive">{{ $customer->staffname }}</td>
                                    <td class="Remarks"> <span class="badge badge-soft text-uppercase"{{ $customer->remarks }}</td> 


                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                 
                                            
                                            <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn" 
                                                 onclick="location.href='{{ route('customers.add') }}'"
                                                wire:click="edit({{ $customer->customer_id }})">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                             
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" 
                                                 onclick="location.href='{{ route('customers.add') }}'" >
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    
                                    <td> 
                                    <button type="button"
                              onclick="location.href='{{ route('customers.add') }}'"
                            
                            class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i>Edit Address Book</button>
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