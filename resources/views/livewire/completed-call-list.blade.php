<div>
    <div class="card" id="onsiteVisitList">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <h5 class="card-title mb-0">Completed Call List (ALT + )</h5>
                </div>
                <div class="col-sm-auto">
                    <button wire:click="toggleFilters" accesskey="S" title="ALT+S" class="btn btn-sm btn-secondary">
                        <i class="ri-filter-line align-bottom me-1"></i> {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
                    </button>
                    <a href="{{ route('onsite-visits.create') }}" accesskey="C" title="ALT+C" class="btn btn-sm btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        @if ($showFilters)
        <div class="card-body border border-dashed border-end-0 border-start-0">
            <form>
                <div class="row g-3">
                    <div class="col-xxl-4 col-sm-6">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm search" placeholder="Search ..." wire:model="search">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive table-card mb-1">
                <table class="table align-middle" id="onsiteVisitTable">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>Customer</th>
                            <th>Tally S.NO</th>
                            <th>Contact Person</th>
                            <th>Mobile Numbers</th>
                            <th>Type Of Call</th>
                            <th>Booking Date & Time</th>
                            <th>Call Start Time</th>
                            <th>Call End Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($onsiteVisits as $visit) <!-- Replace with $onlineCalls for the Online Call List -->
                        <tr>
                            <td>{{ $visit->customer->customer_name }}</td>
                            <td>{{ $visit->customer->tally_serial_no }}</td>
                            <td>{{ $visit->contactPerson->contact_person }}</td>
                            <td>{!! implode('<br>', $visit->contactPerson->mobileNumbers->pluck('mobile_no')->toArray()) !!}</td>
                            <td>{{ $visit->type_of_call }}</td>
                            <td>{{ \Carbon\Carbon::parse($visit->call_booking_time)->format('d-m-y h:i:s A') }}</td>
                            <td>
                                @if($visit->serviceCallLogs->isNotEmpty())
                                @foreach($visit->serviceCallLogs as $log)
                                {{ $log->call_start_time ? \Carbon\Carbon::parse($log->call_start_time)->format('h:i:s A') : '' }}<br>
                                @endforeach
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if($visit->serviceCallLogs->isNotEmpty())
                                @foreach($visit->serviceCallLogs as $log)
                                {{ $log->call_end_time ? \Carbon\Carbon::parse($log->call_end_time)->format('h:i:s A') : '' }}<br>
                                @endforeach
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $visit->status_of_call }}</td>
                            
                           

                            <td>
                                <a href="{{ route('onsite-visits.edit', $visit->id) }}" class="btn btn-sm btn-info">
                                    <i class="ri-edit-line align-bottom me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-end">
                    {{ $onsiteVisits->links() }}
                </div>
            </div>
        </div>


    </div>
</div>