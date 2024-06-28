<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Customer</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form wire:submit.prevent="save" class="form-horizontal form-bordered">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">Customer Name*</label>
                                    <input type="text" class="form-control" id="customer_name" wire:model="customer_name" autofocus placeholder="Enter Customer Name">
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
                                    <label for="product_id">Licence Edition</label>
                                    <select class="form-control" id="product_id" wire:model="product_id">
                                        <option value="">Select Licence Edition</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc" class="form-label">A.M.C.</label>
                                    <select class="form-control" id="amc" wire:model.live="amc">
                                        <option value="yes">YES</option>
                                        <option value="no">NO</option>
                                    </select>
                                    @error('amc') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if ($amc === 'yes')
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc_from_date">A.M.C. From Date</label>
                                    <input type="date" class="form-control" id="amc_from_date" wire:model="amc_from_date" placeholder="Enter A.M.C. From Date">
                                    @error('amc_from_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc_to_date">A.M.C. To Date</label>
                                    <input type="date" class="form-control" id="amc_to_date" wire:model="amc_to_date" placeholder="Enter A.M.C. To Date">
                                    @error('amc_to_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc_renewal_date">A.M.C. Renewal Date</label>
                                    <input type="date" class="form-control" id="amc_renewal_date" wire:model="amc_renewal_date" placeholder="Enter A.M.C. Renewal Date">
                                    @error('amc_renewal_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="no_of_visits">No. of Visits</label>
                                    <input type="number" class="form-control" id="no_of_visits" wire:model="no_of_visits" placeholder="Enter No. of Visits">
                                    @error('no_of_visits') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc_amount">A.M.C. Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amc_amount" wire:model="amc_amount" placeholder="Enter A.M.C. Amount">
                                    @error('amc_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="amc_last_year_amount">A.M.C. Last Year Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amc_last_year_amount" wire:model="amc_last_year_amount" placeholder="Enter A.M.C. Last Year Amount">
                                    @error('amc_last_year_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif

                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="tss_status" class="form-label">T.S.S. Status</label>
                                    <select class="form-control" id="tss_status" wire:model.live="tss_status">
                                        <option value="active">ACTIVE</option>
                                        <option value="inactive">INACTIVE</option>
                                    </select>
                                    @error('tss_status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @if ($tss_status === 'active')
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="tss_expirydate">T.S.S. Expiry Date</label>
                                    <input type="date" class="form-control" id="tss_expirydate" wire:model="tss_expirydate" placeholder="Enter T.S.S. Expiry Date">
                                    @error('tss_expirydate') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="tss_adminemail">T.S.S. Admin E-Mail</label>
                                    <input type="email" class="form-control" id="tss_adminemail" wire:model="tss_adminemail" placeholder="Enter T.S.S Admin Email">
                                    @error('tss_adminemail') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif



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
                                    <label for="executive_id">Followup Executive</label>
                                    <select class="form-control" id="executive_id" wire:model="executive_id">
                                        <option value="">Select Executive</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('executive_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" wire:model="remarks" placeholder="Enter Remarks">
                                    @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
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
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="whatsapp_telegram_group">WhatsApp/Telegram Group</label>
                                    <input type="checkbox" id="whatsapp_telegram_group" wire:model="whatsapp_telegram_group">
                                    @error('whatsapp_telegram_group') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="auto_backup">Auto Backup</label>
                                    <input type="checkbox" id="auto_backup" wire:model="auto_backup">
                                    @error('auto_backup') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="cloud_user">Cloud User</label>
                                    <input type="checkbox" id="cloud_user" wire:model="cloud_user">
                                    @error('cloud_user') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group">
                                    <label for="mobile_app">Mobile App</label>
                                    <input type="checkbox" id="mobile_app" wire:model="mobile_app">
                                    @error('mobile_app') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-group gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush

</div>