@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <div class="col">
                <h4 class="card-title mb-0 flex-grow-1">Edit Email Settings</h4>
            </div>
            <div class="col-auto">
                <a href="{{ url('settings.index') }}" class="btn btn-secondary">Back to Settings</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('email-settings.update') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-4">
                    <label for="email_mail_host" class="form-label">Mail Host</label>
                    <input type="text" class="form-control" id="email_mail_host" name="email[mail_host]" value="{{ old('email.mail_host', $settings['email.mail_host'] ?? '') }}" required>
                    @error('email.mail_host')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_mail_port" class="form-label">Mail Port</label>
                    <input type="text" class="form-control" id="email_mail_port" name="email[mail_port]" value="{{ old('email.mail_port', $settings['email.mail_port'] ?? '') }}" required>
                    @error('email.mail_port')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_mail_encryption" class="form-label">Encryption</label>
                    <input type="text" class="form-control" id="email_mail_encryption" name="email[mail_encryption]" value="{{ old('email.mail_encryption', $settings['email.mail_encryption'] ?? '') }}" required>
                    @error('email.mail_encryption')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_mail_username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="email_mail_username" name="email[mail_username]" value="{{ old('email.mail_username', $settings['email.mail_username'] ?? '') }}" required>
                    @error('email.mail_username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_mail_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="email_mail_password" name="email[mail_password]" value="{{ old('email.mail_password', $settings['email.mail_password'] ?? '') }}" required>
                    @error('email.mail_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_from_address" class="form-label">From Address</label>
                    <input type="email" class="form-control" id="email_from_address" name="email[from_address]" value="{{ old('email.from_address', $settings['email.from_address'] ?? '') }}" required>
                    @error('email.from_address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_from_name" class="form-label">From Name</label>
                    <input type="text" class="form-control" id="email_from_name" name="email[from_name]" value="{{ old('email.from_name', $settings['email.from_name'] ?? '') }}" required>
                    @error('email.from_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
