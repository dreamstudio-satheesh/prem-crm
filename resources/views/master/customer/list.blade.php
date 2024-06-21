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
                            <div class="row g-3">
                             
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
                                        <button type="button"  
                                          onclick="location.href='{{ url('/master/customer/editcustomer') }}/{{$customer->customer_id}}'" 
                                          class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> >
                                          Edit Customer</button>
                                    </td>
                                    
                                    <td> 
                                         
                                    <?php   if($customer->customeraddress_id>0) {   ?>
                                    <button type="button"
                                     onclick="location.href='{{ url('/master/customer/editaddress') }}/{{$customer->customeraddress_id}}'" 
                                     class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i>Edit Address Book</button>
                                     <?php } else { ?>
                                        
                            <button type="button"
                              onclick="location.href='{{ url('/master/customer/editaddressnew') }}/{{$customer->customer_id}}'" 
                            class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i>Create Address Book</button>
                            <?php }  ?>        
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