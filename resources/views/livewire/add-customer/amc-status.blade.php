<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">A.M.C. Status</h4>
    </div>
    <div class="card-body">
        <div class="row gy-4">
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <label for="amc" class="form-label">A.M.C.</label>
                    <select class="form-control" id="amc" wire:model="amc">
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
        </div>
    </div>
</div>
