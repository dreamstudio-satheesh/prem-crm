<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Customer Address</h4>
    </div>
    <div class="card-body">
        <div class="row gy-4">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table border="1" class="table">
                    <thead>
                        <tr>
                            <th width="4%">S.No</th>
                            <th width="10%">Type</th>
                            <th width="10%">Contact Person</th>
                            <th width="10%">Mobile Nos</th>
                            <th width="10%">Phone No</th>
                            <th width="10%">Email</th>
                            <th width="2%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addresses as $index => $address)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <select class="form-control" wire:model="addresses.{{ $index }}.customer_type_id">
                                    <option value="">-- Select Customer Type --</option>
                                    @foreach($addressTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error("addresses.$index.customer_type_id") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.contact_person"></td>
                            <td>
                                @foreach($address['mobile_no'] as $mobileIndex => $mobileNo)
                                <div class="input-group input-group-sm mb-2">
                                    <input type="text" class="form-control" wire:model="addresses.{{ $index }}.mobile_no.{{ $mobileIndex }}">
                                    <button type="button" class="btn btn-danger" wire:click.prevent="removeMobileNumber({{ $index }}, {{ $mobileIndex }})">-</button>
                                </div>
                                @endforeach
                                <button type="button" class="btn btn-success btn-sm" wire:click.prevent="addMobileNumber({{ $index }})">+ Add Mobile No</button>
                            </td>
                            <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.phone_no"></td>
                            <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.email"></td>
                            <td>
                                <button type="button" wire:click.prevent="removeAddress({{ $index }})" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" wire:click.prevent="addAddress" class="btn btn-success">+ Add More</button>
            </div>
        </div>
    </div>
</div>
