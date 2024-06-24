<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
          
            <div class="card-header">
                    <div class="row" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-8">
                            <h2> Customer Categories </h2>
                        </div> 
                        <form action="" 
                        name="yarndeliverydentry"
                        method="post" class="form-horizontal form-bordered">
                        @csrf
                        @method('POST')

                        @foreach($addresstype2 as $rsaddresstype2)   
                        @endforeach
                        <div class="col-md-8">
                             <div class="col-md-4"> 
                               <div class="form-group">
                            <label for="product_id">Primary Category</label>
                           
                            <select  
                            onBlur="saveToDatabase()"
                            class="form-control" id="" name="primary_id"> 
                                @foreach($addresstype1  as $rsaddresstype1) 
                                    <option value="{{ $rsaddresstype1->id }}"
                                    {{ $rsaddresstype1->id== $rsaddresstype2->primaryid ? 'selected' : ''}}>    
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
                           
                            <select 
                            onBlur="saveToDatabase()"
                            class="form-control" id="secondary_id" name="secondary_id"> 
                                @foreach($addresstype1 as $rsaddresstype1) 
                                    <option value="{{ $rsaddresstype1->id }}"
                                    {{ $rsaddresstype1->id== $rsaddresstype2->secondaryid ? 'selected' : ''}}>    
                                    {{ $rsaddresstype1->name }}</option>
                                @endforeach
                            </select>
                            @error('secondary_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            </div> 
                        </div>
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
</form>

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
function  saveToDatabase(){
    var _token = $('input[name="_token"]').val();
   
              primary=($('#primary_id').val()); 
    secondary=($('#secondary_id').val()); 
   // alert(secondary);
   // exit();
    
              var _token = $('input[name="_token"]').val();
                     ///////////////////////////////////
                     $.ajax({
                     url:"{{ route('addresstype.saveprimarycategory') }}",
                     method:"POST", 
                     data:{_token:_token,primary:primary,secondary:secondary} ,
                     success: function(response){                   
                   
                   alert(response);
                     },//sucess
                     error: function (jqXHR, exception) {
                  var msg = '';
                  if (jqXHR.status === 0) {
                      msg = 'Not connect.\n Verify Network.';
                  } else if (jqXHR.status == 404) {
                      msg = 'Requested page not found. [404]';
                  } else if (jqXHR.status == 500) {
                      msg = 'Internal Server Error [500].';
                  } else if (exception === 'parsererror') {
                      msg = 'Requested JSON parse failed.';
                  } else if (exception === 'timeout') {
                      msg = 'Time out error.';
                  } else if (exception === 'abort') {
                      msg = 'Ajax request aborted.';
                  } else {
                      msg = 'Uncaught Error.\n' + jqXHR.responseText;
                  }
                   alert(msg);
                 },
                 
                  headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                  } 
                });
          }             
</script>

    <script>
function saveToDatabasee() { 
     
    primary=($('#primary_id').val()); 
    secondary=($('#secondary_id').val()); 
    
    $.ajax({ 
        url:"{{ route('addresstype.saveprimarycategory') }}", 
		type: "POST",
		data:'primary='+primary+'&secondary='+secondary,
		success: function(data){
		 alert(data); 
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
