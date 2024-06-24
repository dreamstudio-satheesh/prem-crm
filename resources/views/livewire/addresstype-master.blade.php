<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
               
            
            <div class="card-header">
                    <div class="row" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-8">
                            <h2> Customer Categories </h2>
                        </div>
                        @foreach($addresstype2 as $rsaddresstype2) 
                                     $primaryid=$rsaddresstype2->primaryid;
                                     $secondaryid=$rsaddresstype2->secondaryid;
                        @endforeach
                        <div class="col-md-8">
                             <div class="col-md-4"> 
                               <div class="form-group">
                            <label for="product_id">Primary Category</label>
                           <?php
                              $primary=1;
                           ?>
                            <select  wire:model="primary_id"
                            onBlur="saveToDatabase(this,'remarks','<?php  echo $primary ?>','<?php  $primary ?>')"
                            class="form-control" id="" name="primary_id"> 
                                @foreach($addresstype` as $rsaddresstype1) 
                                    <option value="{{ $rsaddresstype1->id }}"
                                    {{ $rsaddresstype1->id== $primaryid ? 'selected' : ''}}>    
                                    {{ $rsaddresstype1->name }}</option>
                                @endforeach
                            </select>
                            @error('primary_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            </div>

                            <div class="col-md-4">
                            <h6> Secondary Category </h6>
                            <div class="form-group"> 
                           <?php
                              $primary=1;
                           ?>
                            <select wire:model="secondary_id"
                            onBlur="saveToDatabase(this,'remarks','<?php  echo $primary ?>','<?php  $primary ?>')"
                            class="form-control" id="secondary_id" name="secondary_id"> 
                                @foreach($addresstype1 as $rsaddresstype1) 
                                    <option value="{{ $rsaddresstype1->id }}"
                                  >
                                    {{ $rsaddresstype1->name }}</option>
                                @endforeach
                            </select>
                            @error('secondary_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            </div>

                        </div>


                        <div class="col-md-4 text-right">
                            <input wire:model.debounce.300ms="search" id="search-box" type="text" class="form-control"
                             placeholder="Search Customer Category...">
                        </div>
                    </div>
                </div> 
                <div class="card-body">
                    <div style="padding-top: 10px">
                        <table class="table table-bordered mt-5">
                            @if ($addresstype->count() > 0)
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Description</th>                                   
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresstype as $rsaddresstype)
                                <tr>
                                    <td>{{ ($addresstype->currentPage() - 1) * $addresstype->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $rsaddresstype->name }}</td>
                                    <td>{{ $rsaddresstype->description }}</td>                                    
                                    <td>
                                        <button wire:click="edit({{ $rsaddresstype->id }})" class="btn btn-primary btn-sm">Edit</button>
                                        <button x-data="{ unitId: {{ $rsaddresstype->id }} }" @click="confirmDeletion(unitId)" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="7">
                                    <h5>No Customer Category found</h5>
                                </td>
                            </tr>
                            @endif
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>{{ $addresstype->links() }}</div>
                            <div class="text-right">Total: {{ $addresstype->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>{{ $id ? 'Edit Customer Categories ' : 'Create Customer Categories ' }}</h5>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" autofocus placeholder="Enter Customer Category name" wire:model="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" placeholder="Enter description" wire:model="description"></textarea>
                            @error('description')
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
function saveToDatabase() { 
     
    primary=($('#primary_id').val()); 
    secondary=($('#primary_id').val()); 
    
    $.ajax({
       
        url:"{{ route('addresstype.saveprimarycategory') }}", 
		type: "POST",
		data:'primary='+primary+'&secondary='+secondary,
		success: function(data){
		 alert(data);
			 //$("#loaderIcon").hide();
			// $("#txtmessage").val(acname+' Remarks Sucessfully Updated !!!');
			//$(editableObj).css("background","pink");
		}        
   });
}
</script>

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
                    Swal.fire('Deleted!', 'Address Type Deleted Successfully.', 'success');
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
