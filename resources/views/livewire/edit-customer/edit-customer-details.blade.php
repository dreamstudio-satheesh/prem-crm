<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Edit Customer Details</h4>
    </div>
    <div class="card-body">
        <div class="row gy-4">
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="customer_name">Customer Name*</label>
                    <input type="text" class="form-control" id="customer_name" wire:model="customer_name" placeholder="Enter Customer Name">
                    @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="tally_serial_no">Tally Serial No</label>
                    <input type="text" class="form-control" id="tally_serial_no" wire:model="tally_serial_no" placeholder="Enter Tally Serial No">
                    @error('tally_serial_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select class="form-control" id="product_id" wire:model="product_id">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="licence_editon_id">Licence Edition</label>
                    <select class="form-control" id="licence_editon_id" wire:model="licence_editon_id">
                        <option value="">Select Licence Edition</option>
                        @foreach($licences as $licence)
                            <option value="{{ $licence->id }}">{{ $licence->name }}</option>
                        @endforeach
                    </select>
                    @error('licence_editon_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="location_id">Customer Location</label>
                    <select class="form-control" id="location_id" wire:model="location_id">
                        <option value="">Select Customer Area</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="profile_status">Profile Status</label>
                    <select class="form-control" id="profile_status" wire:model="profile_status">
                        <option value="Followup">FOLLOW UP</option>
                        <option value="Others">OTHERS</option>
                    </select>
                    @error('profile_status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="staff_id">Followup Executive</label>
                    <select class="form-control" id="staff_id" wire:model="staff_id">
                        <option value="">Select Executive</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('staff_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="map_location">Map Location</label>
                    <input type="text" class="form-control" id="map_location" wire:model="map_location" placeholder="Enter Map Location">
                    @error('map_location') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="gst_no">GST No</label>
                    <input type="text" class="form-control" id="gst_no" wire:model="gst_no" placeholder="Enter GST No">
                    @error('gst_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="tdl_addons">TDL & Addons</label>
                    <input type="text" class="form-control" id="tdl_addons" wire:model="tdl_addons" placeholder="Enter TDL & Addons">
                    @error('tdl_addons') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="input-group">
                    <span class="input-group-text">Remarks</span>
                    <textarea class="form-control" id="remarks" wire:model="remarks" aria-label="remarks" rows="2"></textarea>
                    @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
