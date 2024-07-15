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
                        <label for="customer_name" class="form-label">Customer</label>
                        <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ $visit->customer->customer_name }}" readonly>
                        <input type="hidden" name="customer_id" value="{{ $visit->customer_id }}">
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="contact_person_id" class="form-label">Contact Person</label>
                        <select id="contact_person_id" name="contact_person_id" class="form-control select2">
                            <option value="">Select Contact Person</option>
                            @foreach($contactPersons as $contactPerson)
                            <option value="{{ $contactPerson->address_id }}" {{ $visit->contact_person_id == $contactPerson->address_id ? 'selected' : '' }}>{{ $contactPerson->contact_person }}</option>
                            @endforeach
                            <option value="new_contact_person">Add New Contact Person</option>
                        </select>
                        @error('contact_person_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-mobile-wrapper" style="display: block;">
                        <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                        <div id="contact_person_mobiles"></div> <!-- Container for appending AJAX fetched mobile numbers -->
                        <div id="additional-mobile-numbers"></div> <!-- Separate container for dynamically added mobile numbers -->
                        <button type="button" class="btn btn-link" id="add-mobile-number">Add More Mobile Numbers</button>
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="type_of_call" class="form-label">Type Of Call</label>
                        <select id="type_of_call" name="type_of_call" class="form-control">
                            <option value="AMC Call" {{ $visit->type_of_call == 'AMC Call' ? 'selected' : '' }}>AMC Call</option>
                            <option value="PER Call" {{ $visit->type_of_call == 'PER Call' ? 'selected' : '' }}>PER Call</option>
                            <option value="FREE Call" {{ $visit->type_of_call == 'FREE Call' ? 'selected' : '' }}>FREE Call</option>
                        </select>
                        @error('type_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                        <input type="hidden" name="call_type" id="call_type" value="online_call"> <!-- Hidden input -->
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_start_time" class="form-label">Call Start Time</label>
                        <input type="text" id="call_start_time" name="call_start_time" class="form-control timepicker" value="{{ $visit->call_start_time }}" readonly>
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="text" id="call_end_time" name="call_end_time" class="form-control timepicker" value="{{ $visit->call_end_time }}" readonly>
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" name="status_of_call" class="form-control">
                            <option value="pending" {{ $visit->status_of_call == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $visit->status_of_call == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="on_process" {{ $visit->status_of_call == 'on_process' ? 'selected' : '' }}>On Process</option>
                            <option value="follow_up" {{ $visit->status_of_call == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                            <option value="cancelled" {{ $visit->status_of_call == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="onsite_visit" {{ $visit->status_of_call == 'onsite_visit' ? 'selected' : '' }}>Onsite Visit</option>
                            <option value="online_call" {{ $visit->status_of_call == 'online_call' ? 'selected' : '' }}>Online Call</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="follow-up-date-wrapper" style="display: none;">
                        <label for="follow_up_date" class="form-label">Follow Up Date</label>
                        <input type="date" id="follow_up_date" name="follow_up_date" class="form-control">
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="nature_of_issue_id" class="form-label">Nature of Issue</label>
                        <select id="nature_of_issue_id" name="nature_of_issue_id" class="form-control select2">
                            <option value="">Select Nature of Issue</option>
                            @foreach($issues as $issue)
                            <option value="{{ $issue->id }}" {{ $visit->nature_of_issue_id == $issue->id ? 'selected' : '' }}>{{ $issue->name }}</option>
                            @endforeach
                        </select>
                        @error('nature_of_issue_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="service_charges" class="form-label">Service Charges</label>
                        <input type of="number" id="service_charges" name="service_charges" class="form-control" value="{{ $visit->service_charges }}">
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


<!-- Modal for Adding New Contact Person -->
<div class="modal fade" id="addContactPersonModal" tabindex="-1" aria-labelledby="addContactPersonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactPersonModalLabel">Add New Contact Person</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addContactPersonForm">
                @csrf
                <input type="hidden" id="modal_customer_id" name="customer_id" value="{{ $visit->customer_id }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label for="customer_type_id" class="form-label">Customer Type</label>
                            <select id="customer_type_id" name="customer_type_id" class="form-control">

                            </select>
                        </div>
                        <div class="col-xxl-12">
                            <div>
                                <label for="contact_person" class="form-label">Contact Person Name</label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person name" required>
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-12">
                            <div>
                                <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                                <input type="text" class="form-control" id="contact_person_mobile" name="contact_person_mobile[]" placeholder="Enter mobile number" required>

                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Contact Person</button>
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
            timeFormat: 'h:i A', // Adjust time format as needed
            interval: 30, // Time intervals in minutes
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        // Function to load contact person mobile numbers
        function loadContactPersonMobiles(contactPersonId) {
            $.ajax({
                url: '/onsite-visits/contact-person-mobile/' + contactPersonId, // Update URL as necessary
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
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }

        // Load contact person mobiles on page load if a contact person is selected
        var initialContactPersonId = $('#contact_person_id').val();
        if (initialContactPersonId) {
            loadContactPersonMobiles(initialContactPersonId);
        }

        // Change event to load contact persons' mobiles
        $('#contact_person_id').on('change', function() {
            var contactPersonId = $(this).val();
            if (contactPersonId === 'new_contact_person') {
                loadCustomerTypes();
                $('#addContactPersonModal').modal('show');
            } else if (contactPersonId) {
                // Fetch and display contact person mobile numbers
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


        // Handle submission for adding a new contact person
        $('#addContactPersonForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/contact-persons', // Update this URL to your route for creating a contact person
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addContactPersonModal').modal('hide');
                    $('#contact_person_id').append('<option value="' + response.contactPerson.address_id + '" selected>' + response.contactPerson.contact_person + '</option>');
                },
                error: function(xhr) {
                    console.error('Error creating contact person:', xhr.responseText);
                }
            });
        });

        // Handle adding more mobile number fields dynamically
        $('#add-mobile-number').on('click', function() {
            $('#additional-mobile-numbers').append(
                '<input type="text" class="form-control mt-2" name="contact_person_mobile[]" placeholder="Enter mobile number" required>'
            );
        });


        setTimeout(() => {
            // Format: Day MonthName Year, Hours:Minutes:Seconds AM/PM
            let now = moment().format('DD MMMM YYYY, h:mm:ss A');
            $('#call_start_time').val(now);
        }, 100);

        // Set call end time continuously with a more readable format
        setInterval(() => {
            let now = moment().format('DD MMMM YYYY, h:mm:ss A');
            $('#call_end_time').val(now);
        }, 100);


        $('#status_of_call').on('change', function() {
            var selectedStatus = $(this).val();

            // Change the call type based on the selected status
            $('#call_type').val(selectedStatus === 'onsite_visit' ? 'onsite_visit' : 'online_call');

            // Show or hide the follow-up date input based on the selected status
            if (selectedStatus === 'follow_up') {
                $('#follow-up-date-wrapper').show();
            } else {
                $('#follow-up-date-wrapper').hide();
            }
        });



        function loadCustomerTypes() {
            $.ajax({
                url: '/customer-types', // Ensure this URL is set to wherever your customer types can be fetched from
                type: 'GET',
                success: function(data) {
                    var select = $('#customer_type_id');
                    select.empty().append('<option value="">Select Customer Type</option>');
                    $.each(data, function(index, type) {
                        select.append($('<option>', {
                            value: type.id,
                            text: type.name
                        }));
                    });
                },
                error: function(error) {
                    console.log('Error loading customer types:', error.responseText);
                }
            });
        }
    });
</script>
@endpush