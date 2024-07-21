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
                'email.mail_host' => 'Mail Host',
                'email.mail_port' => 'Mail Port',
                'email.mail_encryption' => 'Encryption',
                'email.mail_username' => 'Username',
                'email.mail_password' => 'Password',
                'email.from_address' => 'From Address',
                'email.from_name' => 'From Name'
                ] as $key => $label)
                <div class="col-md-4">
                    <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                    <input type="{{ $key === 'email.mail_password' ? 'password' : 'text' }}" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" required>
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
