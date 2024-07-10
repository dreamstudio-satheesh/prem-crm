<div>
    <form wire:submit.prevent="save" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <livewire:edit-customer.edit-customer-details :customer="$customer" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <livewire:edit-customer.edit-customer-address :customer="$customer" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <livewire:edit-customer.edit-customer-tss :customer="$customer" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <livewire:edit-customer.edit-customer-amc :customer="$customer" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <livewire:edit-customer.edit-customer-features :customer="$customer" />
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="form-group gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </form>
</div>
