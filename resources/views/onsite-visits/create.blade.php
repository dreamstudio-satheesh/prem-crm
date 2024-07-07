@extends('layouts.admin')

@section('content')
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
            <form id="onsite-visit-form" action="{{ route('onsite-visits.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" name="customer_id" class="form-control select2">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-wrapper" style="display: none;">
                        <label for="contact_person_id" class="form-label">Contact Person</label>
                        <select id="contact_person_id" name="contact_person_id" class="form-control select2">
                            <option value="">Select Contact Person</option>
                        </select>
                        @error('contact_person_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-mobile-wrapper" style="display: none;">
                        <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                        <input type="text" id="contact_person_mobile" name="contact_person_mobile" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3" id="type-of-call-wrapper" style="display: none;">
                        <label for="type_of_call" class="form-label">Type Of Call</label>
                        <select id="type_of_call" name="type_of_call" class="form-control">
                            <option value="AMC Call">AMC Call</option>
                            <option value="PER Call">PER Call</option>
                            <option value="FREE Call">FREE Call</option>
                        </select>
                        @error('type_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_start_time" class="form-label">Call Start Time</label>
                        <input type="text" id="call_start_time" name="call_start_time" class="form-control timepicker">
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="text" id="call_end_time" name="call_end_time" class="form-control timepicker" readonly>
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" name="status_of_call" class="form-control">
                            <option value="">Select Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="service_charges" class="form-label">Service Charges</label>
                        <input type="number" id="service_charges" name="service_charges" class="form-control">
                        @error('service_charges') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control"></textarea>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('.select2').select2();

    $('.timepicker').timepicker({
        timeFormat: 'h:i A',
        interval: 1,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('#customer_id').on('change', function() {
        var customerId = $(this).val();
        if (customerId) {
            $.ajax({
                url: '/onsite-visits/contact-persons/' + customerId,
                type: 'GET',
                success: function(data) {
                    $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
                    $.each(data.contactPersons, function(key, value) {
                        $('#contact_person_id').append('<option value="' + value.address_id + '">' + value.contact_person + '</option>');
                    });
                    $('#contact_person_id').trigger('change');
                    $('#contact-person-wrapper').show();

                    // Set type of call based on customer AMC status
                    if (data.customerAmc == 'yes') {
                        $('#type_of_call').val('AMC Call');
                    } else {
                        $('#type_of_call').val('PER Call');
                    }
                    $('#type-of-call-wrapper').show();
                }
            });
        } else {
            $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
            $('#contact-person-wrapper').hide();
            $('#type-of-call-wrapper').hide();
            $('#contact_person_mobile').val('');
            $('#contact-person-mobile-wrapper').hide();
        }
    });

    $('#contact_person_id').on('change', function() {
        var contactPersonId = $(this).val();
        if (contactPersonId) {
            $.ajax({
                url: '/onsite-visits/contact-person-mobile/' + contactPersonId,
                type: 'GET',
                success: function(data) {
                    $('#contact_person_mobile').val(data.mobile_no);
                    $('#contact-person-mobile-wrapper').show();
                }
            });
        } else {
            $('#contact_person_mobile').val('');
            $('#contact-person-mobile-wrapper').hide();
        }
    });

    // Set call start time after 2 seconds
    setTimeout(() => {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        let formattedTime = `${hours}:${minutes} ${ampm}`;
        console.log('Setting call_start_time:', formattedTime);
        $('#call_start_time').val(formattedTime);
    }, 2000);

    // Update call end time every second
    setInterval(() => {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        let formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;
        $('#call_end_time').val(formattedTime);
    }, 1000);
});

</script>
@endpush
