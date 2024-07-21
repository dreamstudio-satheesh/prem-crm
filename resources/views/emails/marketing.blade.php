@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Send Marketing Email</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('send.marketing.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="recipients" class="form-label">Select Recipients</label>
                    <select class="form-control" id="recipients" name="recipients[]" multiple>
                        @foreach($customers as $customer)
                        @if($customer->addressBooks)
                        <optgroup label="{{ $customer->customer_name }}">
                            @foreach($customer->addressBooks as $addressBook)
                            <option value="{{ $addressBook->email }}">{{ $addressBook->contact_person }} - {{ $addressBook->email }}</option>
                            @endforeach
                        </optgroup>
                        @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Send Email</button>
            </form>
        </div>
    </div>
</div>
@endsection
