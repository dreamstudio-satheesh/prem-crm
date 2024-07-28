@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header align-items-center d-flex">
        <div class="col">
            <h4 class="card-title mb-0 flex-grow-1">Import Customer - Preview</h4>
        </div>
        <div class="col-auto">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
    <div class="card-body">
        <form id="importForm" action="{{ route('customer_import.import') }}" method="POST">
            @csrf
            <input type="hidden" name="tempFilePath" value="{{ $tempFilePath }}">
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            @foreach($headers as $index)
                            <th style="min-width: 150px;">
                                {{ $rawHeaders[$index] }}
                                <select name="mappings[{{ $index }}]" class="form-select form-select-sm import-select" data-index="{{ $index }}">
                                    <option value="">Select Field</option>
                                    @foreach($columnOptions as $field => $label)
                                    <option value="{{ $field }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previewData as $row)
                        <tr>
                            @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-info mt-3">Import Data</button>
            <a href="{{ route('customer_import.show') }}" class="btn btn-secondary mt-3">Reset</a>
        </form>
    </div>
</div>

@endsection

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let selects = document.querySelectorAll('.import-select');

        function updateSelectOptions() {
            let selectedValues = Array.from(selects).map(select => select.value).filter(value => value !== "");

            selects.forEach(select => {
                let currentValue = select.value;
                select.querySelectorAll('option').forEach(option => {
                    if (option.value !== "" && option.value !== currentValue) {
                        option.remove();
                    } else {
                        option.disabled = false;
                    }
                });

                for (let value of selectedValues) {
                    if (value !== currentValue) {
                        let option = select.querySelector('option[value="' + value + '"]');
                        if (option) {
                            option.remove();
                        }
                    }
                }

                select.value = currentValue; // Restore the current value
            });
        }

        selects.forEach(select => {
            select.addEventListener('change', updateSelectOptions);
        });

        updateSelectOptions();
    });

    document.getElementById('importForm').addEventListener('submit', function(event) {
        let selects = document.querySelectorAll('.import-select');
        let selectedFields = {};
        let tallySerialSelected = false;
        let duplicateSelection = false;

        selects.forEach(function(select) {
            let value = select.value;
            if (value) {
                if (value === 'tally_serial_no') {
                    tallySerialSelected = true;
                }
                if (selectedFields[value]) {
                    duplicateSelection = true;
                } else {
                    selectedFields[value] = true;
                }
            }
        });

        if (!tallySerialSelected) {
            alert('Please select the Tally Serial No field.');
            event.preventDefault();
        } else if (duplicateSelection) {
            alert('Each field can only be selected once.');
            event.preventDefault();
        }
    });
    </script>
@endpush
