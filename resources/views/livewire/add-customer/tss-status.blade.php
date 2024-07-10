<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">T.S.S. Status</h4>
    </div>
    <div class="card-body">
        <div class="row gy-4">
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="tss_status" class="form-label">T.S.S. Status</label>
                    <select class="form-control" id="tss_status" wire:model="tss_status">
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
        </div>
    </div>
</div>
