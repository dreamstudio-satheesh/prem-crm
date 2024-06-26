<div>

    <div class="row">

        <div class="col-md-12">

            <div class="card  px-3" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>Add Customer Address Book</h5>
                </div>

                <form wire:submit.prevent="save" class="form-horizontal form-bordered">
                    <div class="form-body">
                        <br>
                        <div class="form-group row">
                            <label for="customer_name" class="control-label text-left col-md-2">Customer</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="customer_name" name="customer_name" readonly value="{{ $customer_name }}">
                                <input type="hidden" class="form-control" id="customer_code" name="customer_code" value="{{ $customer_id }}">
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table border="1" class="table">
                                <thead>
                                    <tr>
                                        <th width="2%"><input id="check_all" class="" type="checkbox" /></th>
                                        <th width="4%">S.No</th>
                                        <th width="10%">Type</th>
                                        <th width="10%">Contact Person</th>
                                        <th width="10%">Mobile No</th>
                                        <th width="10%">Phone No</th>
                                        <th width="10%">e-Mail</th>
                                        <th width="2%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($addresses as $index => $address)
                                    <tr>
                                        <td><input class="case" type="checkbox" /></td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <select class="form-control" wire:model="addresses.{{ $index }}.address_type_id">
                                                <option value="">-- Select Customer Type --</option>
                                                @foreach($addressTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("addresses.$index.address_type_id") <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.contact_person"></td>
                                        <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.mobile_no"></td>
                                        <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.phone_no"></td>
                                        <td><input type="text" class="form-control" wire:model="addresses.{{ $index }}.email"></td>
                                        <td>
                                            <button type="button" wire:click.prevent="removeAddress({{ $index }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <button type="button" wire:click.prevent="addAddress" class="btn btn-success">+ Add More</button>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="offset-sm-3 col-md-7">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-check"></i> Save
                                                </button>
                                                <a href="{{ url('/master/customers') }}" class="btn btn-inverse">Cancel</a>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>

        </div>

    </div>


</div>