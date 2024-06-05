@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    @if($report->isEmpty())
        <p>No data available for today.</p>
    @else
        <table class="table table-striped-columns table-card">
            <caption class="caption-top">Today's Hourly Production Report</caption>
            <thead class="table-light">
                <tr>
                    <th scope="col">Section</th>
                    <th scope="col">Line ID</th>
                    <th scope="col">Checkpoint</th>
                    @foreach($hours as $hour)
                        <th scope="col">{{ $hour % 12 == 0 ? 12 : $hour % 12 }} {{ $hour < 12 ? 'AM' : 'PM' }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($report as $lineId => $lineCheckpoints)
                    @foreach($lineCheckpoints as $checkpoint)
                        <tr>
                            <td>{{ $checkpoint->section }}</td>
                            <td>{{ $checkpoint->line_id }}</td>
                            <td>{{ $checkpoint->checkpoint_no }}</td>
                            @foreach($checkpoint->hourly_report as $hour => $count)
                                <td>{{ $count }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
</div>

    
@endsection