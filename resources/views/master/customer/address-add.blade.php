@extends('layouts.admin')

@section('content')

@livewire('add-address', ['customerId' => $customerId])

    
@endsection