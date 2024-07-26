<!-- resources/views/customer_import_preview.blade.php -->


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
        <form action="{{ route('customer_import.import') }}" method="POST">
            @csrf
            <input type="hidden" name="tempFilePath" value="{{ $tempFilePath }}">
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach($headers as $header)
                            <th>
                                {{ $header }}
                                <select name="mappings[{{ $header }}]" class="form-control">
                                    <option value="">Select Field</option>
                                    @foreach($columnOptions as $field => $label)
                                    <option value="{{ $field }}">{{ $field }}</option>
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
