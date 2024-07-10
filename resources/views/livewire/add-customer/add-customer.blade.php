<div>
    <form wire:submit.prevent="save" class="form-horizontal form-bordered">
        <livewire:add-customer.customer-details />
        <livewire:add-customer.customer-address />
        <livewire:add-customer.tss-status />
        <livewire:add-customer.amc-status />
        <livewire:add-customer.other-settings />

        <div class="col-xxl-3 col-md-6">
            <div class="form-group gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </form>
</div>
