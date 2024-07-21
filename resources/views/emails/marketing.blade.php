@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Send Marketing Email</h1>
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
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="send_to_all" name="send_to_all">
            <label class="form-check-label" for="send_to_all">Send to All Customers</label>
        </div>
        <div class="mb-3">
            <label for="recipients" class="form-label">Select Recipients</label>
            <select class="form-control" id="recipients" name="recipients[]" multiple>
                @foreach($customers as $customer)
                    <option value="{{ $customer->email }}">{{ $customer->name }} - {{ $customer->email }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>
@endsection
