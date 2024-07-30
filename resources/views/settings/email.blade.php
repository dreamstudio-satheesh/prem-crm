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
                @foreach ([
                'mail_host' => 'Mail Host',
                'mail_port' => 'Mail Port',
                'mail_encryption' => 'Encryption',
                'mail_username' => 'Username',
                'mail_password' => 'Password',
                'from_address' => 'From Address',
                'from_name' => 'From Name'
                ] as $key => $label)
                <div class="col-md-4">
                    <label for="email_{{ $key }}" class="form-label">{{ $label }}</label>
                    <input type="{{ $key === 'mail_password' ? 'password' : 'text' }}" class="form-control" id="email_{{ $key }}" name="email[{{ $key }}]" value="{{ old('email.' . $key, $settings['email.' . $key] ?? '') }}" required>
                </div>
                @endforeach

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
