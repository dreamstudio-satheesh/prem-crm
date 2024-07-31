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
                            <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                {{ $customer->customer_name }}
                            </option>
                            @endforeach
                            <option value="new_customer">Add New Customer</option>
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="col-md-4 mb-3" id="contact-person-wrapper" style="display: none;">
                        <label for="contact_person_id" class="form-label">Contact Person</label>
                        <select id="contact_person_id" name="contact_person_id" class="form-control select2">
                            <option value="">Select Contact Person</option>
                            <option value="new_contact_person">Add New Contact Person</option>
                        </select>
                        @error('contact_person_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="contact-person-mobile-wrapper" style="display: none;">
                        <label for="contact_person_mobile" class="form-label">Contact Person Mobile</label>
                        <div id="contact_person_mobiles"></div> <!-- Container for appending AJAX fetched mobile numbers -->

                        <div id="additional-mobile-numbers"></div> <!-- Separate container for dynamically added mobile numbers -->
                        <button type="button" class="btn btn-link" id="add-mobile-number">Add</button>

                    </div>


                    <div class="col-md-4 mb-3" id="type-of-call-wrapper" style="display: none;">
                        <label for="type_of_call" class="form-label">Type Of Call</label>
                        <select id="type_of_call" name="type_of_call" class="form-control">
                            <option value="AMC Call">AMC Call</option>
                            <option selected value="PER Call">PER Call</option>
                            <option value="FREE Call">FREE Call</option>
                        </select>
                        @error('type_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_booking_time" class="form-label">Call Booking Time</label>
                        <input type="text" id="call_booking_time" name="call_booking_time" class="form-control timepicker" readonly>
                        @error('call_booking_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" name="status_of_call" class="form-control">
                            <option value="">Select Status</option>
                            <option selected value="pending">Pending</option>
                            <!--  <option value="on_process">On Process</option> -->
                            <option value="follow_up">Follow Up</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror

                        <input type="hidden" name="call_type" id="call_type" value="online_call"> <!-- Hidden input -->
                    </div>

                    <div class="col-md-4 mb-3" id="follow-up-date-wrapper" style="display: none;">
                        <label for="follow_up_date" class="form-label">Follow Up Date</label>
                        <input type="date" id="follow_up_date" name="follow_up_date" class="form-control">
                    </div>



                    <div class="col-md-4 mb-3">
                        <label for="staff_id" class="form-label">Executive (Assign To)</label>
                        <select id="staff_id" name="staff_id" class="form-control select2">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $staffId ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('staff_id') <span class="text-danger">{{ $message }}</span> @enderror
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

    <!-- Modal for Adding New Customer -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCustomerForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-xxl-12">
                                <div>
                                    <label for="customer_name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-12">
                                <div>
                                    <label for="tally_serial_no" class="form-label">Tally Serial No</label>
                                    <input type="text" class="form-control" id="tally_serial_no" name="tally_serial_no" placeholder="Enter tally serial number">
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Customer</button>
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
                    <input type="hidden" id="modal_customer_id" name="customer_id">
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

        // Initialize timepicker
        $('.timepicker').timepicker({
            timeFormat: 'h:i:s A',
            interval: 1,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        // Fetch and display contact persons based on customer selection
        $('#customer_id').on('change', function() {
            var customerId = $(this).val();
            if (customerId === 'new_customer') {
                $('#addCustomerModal').modal('show');
                return;
            }

            // Set customer ID in the hidden input for the Add Contact Person Form
            $('#modal_customer_id').val(customerId);

            if (customerId) {
                $.ajax({
                    url: '/onsite-visits/contact-persons/' + customerId,
                    type: 'GET',
                    success: function(data) {
                        $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
                        $.each(data.contactPersons, function(key, value) {
                            $('#contact_person_id').append('<option value="' + value.address_id + '">' + value.contact_person + '</option>');
                        });

                        // Add option to add new contact person
                        $('#contact_person_id').append('<option value="new_contact_person">Add New Contact Person</option>');

                        if (data.primaryAddressId) {
                            $('#contact_person_id').val(data.primaryAddressId).trigger('change');
                        }
                        $('#contact-person-wrapper').show();
                        $('#type-of-call-wrapper').show();
                        $('#contact-person-mobile-wrapper').hide();

                        // Set Type Of Call based on customerAmc value
                        if (data.customerAmc) {
                            $('#type_of_call').val('AMC Call');
                        } else {
                            $('#type_of_call').val('PER Call');
                        }

                    }
                });
            } else {
                $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
                $('#contact-person-wrapper').hide();
                $('#type-of-call-wrapper').hide();
                $('#contact_person_mobiles').empty();
                $('#contact-person-mobile-wrapper').hide();
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
                            var selectHtml = '<select class="form-select" aria-label="Select mobile number">';
                            selectHtml += '<option value="">Select</option>';
                            data.mobile_no.forEach(function(mobileNumber) {
                                selectHtml += `<option value="${mobileNumber}">${mobileNumber}</option>`;
                            });
                            selectHtml += '</select>';
                            mobilesContainer.append(selectHtml);
                        } else {
                            mobilesContainer.append('<p>No mobile number available</p>');
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

        // Handle adding more mobile number fields dynamically
        $('#add-mobile-number').on('click', function() {
            var additionalMobileNumbers = $('#additional-mobile-numbers');
            if (additionalMobileNumbers.find('input').length === 0) { // Check if an input already exists
                additionalMobileNumbers.append('<input type="text" class="form-control mt-2" name="contact_person_mobile" placeholder="Enter mobile number" required>');
            }

            $('#contact_person_mobiles').hide();
        });


        setTimeout(() => {
            let now = moment().format('h:mm:ss A');
            $('#call_booking_time').val(now);
        }, 2000);



        // Handle the form submission for adding a new customer
        $('#addCustomerForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/customers', // Update this URL to your route for creating a customer
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCustomerModal').modal('hide');
                    $('#customer_id').append('<option value="' + response.customer.customer_id + '">' + response.customer.customer_name + '</option>');
                    $('#customer_id').val(response.customer.customer_id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error creating customer:', xhr.responseText);
                    // Handle validation errors
                }
            });
        });

        // Handle the form submission for adding a new contact person
        $('#addContactPersonForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/contact-persons', // Update this URL to your route for creating a contact person
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addContactPersonModal').modal('hide');
                    $('#contact_person_id').append('<option value="' + response.contactPerson.address_id + '">' + response.contactPerson.contact_person + '</option>');
                    $('#contact_person_id').val(response.contactPerson.address_id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error creating contact person:', xhr.responseText);
                    // Handle validation errors
                }
            });
        });



        $('#status_of_call').on('change', function() {
            var selectedStatus = $(this).val();
            if (selectedStatus === 'follow_up') {
                $('#follow-up-date-wrapper').show();
            } else {
                $('#follow-up-date-wrapper').hide();
            }
        });

    });
</script>

@endpush