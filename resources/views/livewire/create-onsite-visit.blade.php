<div>

    <div class="card">
        <div class="card-header align-items-center d-flex">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Create Onsite Visit</h4>
            </div>

            <div class="col-auto">
                <a href="{{ route('onsite-visits.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" wire:model="customer_id" class="form-control select2">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    @if ($customer_id)
                        <div class="col-md-4 mb-3">
                            <label for="contact_person_id" class="form-label">Contact Person</label>
                            <select id="contact_person_id" wire:model.lazy="contact_person_id" class="form-control select2">
                                <option value="">Select Contact Person</option>
                                @foreach($contactPersons as $contactPerson)
                                    <option value="{{ $contactPerson->address_id }}">{{ $contactPerson->contact_person }}</option>
                                @endforeach
                            </select>
                            @error('contact_person_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @if ($contact_person_id)
                            <div class="col-md-4 mb-3">
                                <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                                <input type="text" id="contact_person_mobile" wire:model="contact_person_mobile" class="form-control" readonly>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label for="type_of_call" class="form-label">Type Of Call</label>
                            <input type="text" id="type_of_call" wire:model="type_of_call" class="form-control">
                            @error('type_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="col-md-4 mb-3">
                        <label for="call_start_time" class="form-label">Call Start Time</label>
                        <input type="datetime-local" id="call_start_time" wire:model="call_start_time" class="form-control">
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="datetime-local" id="call_end_time" wire:model="call_end_time" class="form-control">
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" wire:model="status_of_call" class="form-control">
                            <option value="">Select Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</select>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="service_charges" class="form-label">Service Charges</label>
                        <input type="number" id="service_charges" wire:model="service_charges" class="form-control">
                        @error('service_charges') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" wire:model="remarks" class="form-control"></textarea>
                        @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Create Onsite Visit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', function () {
        initSelect2();

        Livewire.hook('message.processed', (message, component) => {
            initSelect2();
        });

        function initSelect2() {
            $('.select2').select2();
            $('.select2').on('change', function (e) {
                var data = $(this).val();
                @this.set($(this).attr('id'), data);
            });
        }
    });
</script>
@endpush
