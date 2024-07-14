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
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" name="customer_id" class="form-control select2">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}" {{ $visit->customer_id == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
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
                        <div id="contact_person_mobiles"></div>
                        <div id="additional-mobile-numbers"></div>
                        <button type="button" class="btn btn-link" id="add-mobile-number">Add More Mobile Numbers</button>
                    </div>

                    <div class="col-md-4 mb-3" id="type-of-call-wrapper" style="display: none;">
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
                        <input type="text" id="call_start_time" name="call_start_time" class="form-control timepicker" value="{{ old('call_start_time', $visit->call_start_time ? $visit->call_start_time->format('h:i:s A') : '') }}" readonly>
                        @error('call_start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="call_end_time" class="form-label">Call End Time</label>
                        <input type="text" id="call_end_time" name="call_end_time" class="form-control timepicker" value="{{ old('call_end_time', $visit->call_end_time ? $visit->call_end_time->format('h:i:s A') : '') }}" readonly>
                        @error('call_end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_of_call" class="form-label">Status of the Call</label>
                        <select id="status_of_call" name="status_of_call" class="form-control">
                            <option value="">Select Status</option>
                            <option value="pending" {{ $visit->status_of_call == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="on_process" {{ $visit->status_of_call == 'on_process' ? 'selected' : '' }}>On Process</option>
                            <option value="follow_up" {{ $visit->status_of_call == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                            <option value="completed" {{ $visit->status_of_call == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="onsite_visit" {{ $visit->status_of_call == 'onsite_visit' ? 'selected' : '' }}>Onsite Visit</option>
                        </select>
                        @error('status_of_call') <span class="text-danger">{{ $message }}</span> @enderror
                        <input type="hidden" name="call_type" id="call_type" value="{{ $visit->call_type }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nature_of_issue_id" class="form-label">Nature of Issue</label>
                        <select id="nature_of_issue_id" name="nature_of_issue_id" class="form-control select2" tabindex="6">
                            <option value="">Select Nature of Issue</option>
                            @foreach($issues as $issue)
                            <option value="{{ $issue->id }}" {{ $visit->nature_of_issue_id == $issue->id ? 'selected' : '' }}>{{ $issue->name }}</option>
                            @endforeach
                        </select>
                        @error('nature_of_issue_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="service_charges" class="form-label">Service Charges</label>
                        <input type="number" id="service_charges" name="service_charges" class="form-control" value="{{ old('service_charges', $visit->service_charges) }}">
                        @error('service_charges') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="staff_id" class="form-label">Assigned Staff</label>
                        <select id="staff_id" name="staff_id" class="form-control select2">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $visit->staff_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('staff_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks', $visit->remarks) }}</textarea>
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

        const customerSelect = $('#customer_id').select2();
        customerSelect.on('select2:open', () => {
            setTimeout(() => {
                const searchInput = document.querySelector('.select2-container--open .select2-search--dropdown .select2-search__field');
                if (searchInput) {
                    searchInput.focus();
                }
            }, 50);
        });

        $('.timepicker').timepicker({
            timeFormat: 'h:i:s A',
            interval: 1,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#customer_id').on('change', function() {
            var customerId = $(this).val();
            if (customerId === 'new_customer') {
                $('#addCustomerModal').modal('show');
                return;
            }

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

                        $('#contact_person_id').append('<option value="new_contact_person">Add New Contact Person</option>');

                        if (data.primaryAddressId) {
                            $('#contact_person_id').val(data.primaryAddressId).trigger('change');
                        }
                        $('#contact-person-wrapper').show();
                        $('#type-of-call-wrapper').show();
                    }
                });
            } else {
                $('#contact_person_id').empty().append('<option value="">Select Contact Person</option>');
                $('#contact-person-wrapper').hide();
                $('#type-of-call-wrapper').hide();
            }
        });

        function loadCustomerTypes() {
            $.ajax({
                url: '/customer-types',
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
                $.ajax({
                    url: '/onsite-visits/contact-person-mobile/' + contactPersonId,
                    type: 'GET',
                    success: function(data) {
                        var mobilesContainer = $('#contact_person_mobiles');
                        mobilesContainer.empty();

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

        $('#add-mobile-number').on('click', function() {
            $('#additional-mobile-numbers').append(
                '<input type="text" class="form-control mt-2" name="contact_person_mobile[]" placeholder="Enter mobile number" required>'
            );
        });

        $('#status_of_call').change(function() {
            $('#call_type').val(this.value === 'onsite_visit' ? 'onsite_visit' : 'online_call');
        });

        $('#addCustomerForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/customers',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCustomerModal').modal('hide');
                    $('#customer_id').append('<option value="' + response.customer.customer_id + '">' + response.customer.customer_name + '</option>');
                    $('#customer_id').val(response.customer.customer_id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error creating customer:', xhr.responseText);
                }
            });
        });

        $('#addContactPersonForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/contact-persons',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addContactPersonModal').modal('hide');
                    $('#contact_person_id').append('<option value="' + response.contactPerson.address_id + '">' + response.contactPerson.contact_person + '</option>');
                    $('#contact_person_id').val(response.contactPerson.address_id).trigger('change');
                },
                error: function(xhr) {
                    console.error('Error creating contact person:', xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
