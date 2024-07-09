@extends('layouts.admin')

@section('content')
<div>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Create Online Calls</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('online-calls.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <form id="online-call-form" action="{{ route('online-calls.store') }}" method="POST">
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
                        <input type="text" id="call_start_time" name="call_start_time" class="form-control timepicker" readonly>
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="text" id="call_end_time" name="call_end_time" class="form-control timepicker" readonly>
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" id="status_of_call" name="status_of_call" class="form-control">
                            <option value="">Select Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="onsite_visit">Onsite Visit</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror

                        <input type="hidden" name="call_type" id="call_type" value="online_call"> <!-- Hidden input -->
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nature_of_issue_id" class="form-label">Nature of Issue</label>
                        <select id="nature_of_issue_id" name="nature_of_issue_id" class="form-control select2" tabindex="6">
                            <option value="">Select Nature of Issue</option>
                            @foreach($issues as $issue)
                            <option value="{{ $issue->id }}">{{ $issue->name }}</option>
                            @endforeach
                        </select>
                        @error('nature_of_issue_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                        <button type="submit" class="btn btn-primary">Create Online Calls</button>
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

        // Initialize Select2 for customer dropdown
        const customerSelect = $('#customer_id').select2();
        customerSelect.on('select2:open', () => {
            setTimeout(() => {
                const searchInput = document.querySelector('.select2-container--open .select2-search--dropdown .select2-search__field');
                if (searchInput) {
                    searchInput.focus();
                }
            }, 50);
        });

        // Trigger the open event to focus on the search input on page load
        customerSelect.select2('open');

        $('.timepicker').timepicker({
            timeFormat: 'h:i:s A',
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
            let now = moment().format('h:mm:ss A');
            $('#call_start_time').val(now);
        }, 2000);

        // Update call end time every second
        setInterval(() => {
            let now = moment().format('h:mm:ss A');
            $('#call_end_time').val(now);
        }, 1000);

        // Handle form submission with AJAX
        $('#online-call-form').on('submit', function(e) {
            e.preventDefault();

            // Format time fields using moment.js
            let callStartTime = moment($('#call_start_time').val(), 'h:mm:ss A').format('h:mm:ss A');
            let callEndTime = $('#call_end_time').val() ? moment($('#call_end_time').val(), 'h:mm:ss A').format('h:mm:ss A') : null;

            let formData = $(this).serializeArray();

            // Remove any existing call_start_time and call_end_time fields
            formData = formData.filter(item => item.name !== 'call_start_time' && item.name !== 'call_end_time');

            formData.push({
                name: 'call_start_time',
                value: callStartTime
            });
            formData.push({
                name: 'call_end_time',
                value: callEndTime
            });

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    window.location.href = '/online-calls';
                },
                error: function(xhr) {
                    console.error('Submission error:', xhr.responseText);
                    // Handle validation errors
                    // Display the validation error messages
                }
            });
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        const statusOfCallElement = document.getElementById('status_of_call');
        const callTypeInput = document.getElementById('call_type');

        statusOfCallElement.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'onsite_visit') {
                callTypeInput.value = 'onsite_visit';
            } else {
                callTypeInput.value = 'online_call'; // Default call type
            }
        });
    });
</script>
@endpush