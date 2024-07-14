@extends('layouts.admin')

@section('content')
<div>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Edit Online Call</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('online-calls.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <form id="online-call-form" action="{{ route('online-calls.update', $visit->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" name="customer_id" class="form-control select2">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}" {{ $visit->customer_id == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-wrapper" style="display: block;">
                        <label for="contact_person_id" class="form-label">Contact Person</label>
                        <select id="contact_person_id" name="contact_person_id" class="form-control select2">
                            <option value="">Select Contact Person</option>
                            @foreach($contactPersons as $contactPerson)
                            <option value="{{ $contactPerson->address_id }}" {{ $visit->contact_person_id == $contactPerson->address_id ? 'selected' : '' }}>{{ $contactPerson->contact_person }}</option>
                            @endforeach
                        </select>
                        @error('contact_person_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-mobile-wrapper" style="display: block;">
                        <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                        <div id="contact_person_mobiles"></div>
                        <div id="additional-mobile-numbers"></div> <!-- Separate container for dynamically added mobile numbers -->
                        <button type="button" class="btn btn-link" id="add-mobile-number">Add More Mobile Numbers</button>
                    </div>

                    <div class="col-md-4 mb-3" id="type-of-call-wrapper" style="display: block;">
                        <label for="type_of_call" class="form-label">Type Of Call</label>
                        <select id="type_of_call" name="type_of_call" class="form-control">
                            <option value="AMC Call" {{ $visit->type_of_call == 'AMC Call' ? 'selected' : '' }}>AMC Call</option>
                            <option value="PER Call" {{ $visit->type_of_call == 'PER Call' ? 'selected' : '' }}>PER Call</option>
                            <option value="FREE Call" {{ $visit->type_of_call == 'FREE Call' ? 'selected' : '' }}>FREE Call</option>
                        </select>
                        @error('type_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_start_time" class="form-label">Call Start Time</label>
                        <input type="text" id="call_start_time" name="call_start_time" class="form-control timepicker" value="{{ $visit->call_start_time->format('h:i:s A') }}">
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="text" id="call_end_time" name="call_end_time" class="form-control timepicker" value="{{ $visit->call_end_time ? $visit->call_end_time->format('h:i:s A') : '' }}" readonly>
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" id="status_of_call" name="status_of_call" class="form-control">
                            <option value="completed" {{ $visit->status_of_call == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ $visit->status_of_call == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="onsite_visit">Onsite Visit</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror

                        <input type="hidden" name="call_type" id="call_type" value="online_call">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nature_of_issue_id" class="form-label">Nature of Issue</label>
                        <select id="nature_of_issue_id" name="nature_of_issue_id" class="form-control select2" tabindex="6">
                            <option value="">Select Nature of Issue</option>
                            @foreach($issues as $issue)
                            <option   value="{{ $issue->id }}" {{ $visit->nature_of_issue_id == $issue->id ? 'selected' : '' }}>{{ $issue->name }}</option>
                            @endforeach
                        </select>
                        @error('nature_of_issue_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="service_charges" class="form-label">Service Charges</label>
                        <input type="number" id="service_charges" name="service_charges" class="form-control" value="{{ $visit->service_charges }}">
                        @error('service_charges') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control">{{ $visit->remarks }}</textarea>
                        @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update Online Call</button>
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
                    }
                });
            } else {
                $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
                $('#contact-person-wrapper').hide();
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
                        var mobilesContainer = $('#contact_person_mobiles');
                        mobilesContainer.empty(); // Clear existing content

                        if (data.mobile_no && data.mobile_no.length > 0) {
                            data.mobile_no.forEach(function(mobileNumber) {
                                mobilesContainer.append(`<input type="text" class="form-control mt-2" value="${mobileNumber}" readonly>`);
                            });
                        } else {
                            mobilesContainer.append('<input type="text" class="form-control mt-2" value="No mobile number available" readonly>');
                        }
                        $('#contact-person-mobile-wrapper').show();
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            } else {
                $('#contact_person_mobiles').empty();
                $('#contact-person-mobile-wrapper').hide();
            }
        });

        // Pre-fill the mobile numbers for the selected contact person
        function prefillContactPersonMobile() {
            var contactPersonId = $('#contact_person_id').val();
            if (contactPersonId) {
                $.ajax({
                    url: '/onsite-visits/contact-person-mobile/' + contactPersonId,
                    type: 'GET',
                    success: function(data) {
                        var mobilesContainer = $('#contact_person_mobiles');
                        mobilesContainer.empty(); // Clear existing content

                        if (data.mobile_no && data.mobile_no.length > 0) {
                            data.mobile_no.forEach(function(mobileNumber) {
                                mobilesContainer.append(`<input type="text" class="form-control mt-2" value="${mobileNumber}" readonly>`);
                            });
                        } else {
                            mobilesContainer.append('<input type="text" class="form-control mt-2" value="No mobile number available" readonly>');
                        }
                        $('#contact-person-mobile-wrapper').show();
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }
        }

        prefillContactPersonMobile();

        $('#add-mobile-number').on('click', function() {
            $('#additional-mobile-numbers').append(
                '<input type="text" class="form-control mt-2" name="contact_person_mobile[]" placeholder="Enter mobile number" required>'
            );
        });

        document.getElementById('online-call-form').onsubmit = function() {
            let callStartTime = moment($('#call_start_time').val(), 'h:mm:ss A').format('h:mm:ss A');
            let callEndTime = $('#call_end_time').val() ? moment($('#call_end_time').val(), 'h:mm:ss A').format('h:mm:ss A') : null;

            $('#call_start_time').val(callStartTime);
            $('#call_end_time').val(callEndTime);
        };
    });

    document.addEventListener('DOMContentLoaded', function() {
        const statusOfCallElement = document.getElementById('status_of_call');
        const callTypeInput = document.getElementById('call_type');

        statusOfCallElement.addEventListener('change', function() {
            const selectedValue = this.value;
            callTypeInput.value = selectedValue === 'onsite_visit' ? 'onsite_visit' : 'online_call';
        });
    });
</script>
@endpush
