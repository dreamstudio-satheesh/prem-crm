@extends('layouts.admin')

@section('content')

@livewire('edit-address', ['customerId' => $customerId])

    
@endsection