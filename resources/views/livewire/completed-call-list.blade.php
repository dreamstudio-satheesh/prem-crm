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
                    <div class="col-xxl-3 col-sm-4">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm search" placeholder="Search ..." wire:model="search">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-4">
                        <select class="form-control form-control-sm" wire:model.lazy="callType">
                            <option value="">All Types</option>
                            <option value="onsite_visit">Onsite Visit</option>
                            <option value="online_call">Online Call</option>
                        </select>
                    </div>
                    <div class="col-xxl-3 col-sm-4">
                        <div x-data="{ open: false, date: @entangle('date') }">
                            <input type="text" readonly x-model="date" @click="open = !open" class="form-control" />
                            <div x-show="open" @click.away="open = false">
                                <div class="date-picker">
                                    <!-- Custom date picker or use a library that works with Alpine.js -->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xxl-3 col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="endDate" wire:model="endDate" placeholder="End Date">
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
                            <th>S.No</th>
                            <th>Customer</th>
                            <th>Tally S.NO</th>
                            <th>Contact Person</th>
                            <th>Mobile Numbers</th>
                            <th>Type Of Call</th>
                            <th>Booking Date & Time</th>
                            <th>Call Start Time</th>
                            <th>Call End Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($onsiteVisits as $index => $visit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $visit->customer->customer_name }}</td>
                            <td>{{ $visit->customer->tally_serial_no }}</td>
                            <td>{{ $visit->contactPerson->contact_person }}</td>
                            <td>{!! implode('<br>', $visit->contactPerson->mobileNumbers->pluck('mobile_no')->toArray()) !!}</td>
                            <td>{{ $visit->type_of_call }}</td>
                            <td>{{ \Carbon\Carbon::parse($visit->call_booking_time)->format('d M h:i:s A') }}</td>
                            <td>
                                @foreach($visit->serviceCallLogs as $log)
                                {{ $log->call_start_time ? \Carbon\Carbon::parse($log->call_start_time)->format('h:i:s A') : 'N/A' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($visit->serviceCallLogs as $log)
                                {{ $log->call_end_time ? \Carbon\Carbon::parse($log->call_end_time)->format('h:i:s A') : 'N/A' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($visit->serviceCallLogs as $log)
                                @if($log->call_start_time && $log->call_end_time)
                                {{ \Carbon\Carbon::parse($log->call_start_time)->diff(\Carbon\Carbon::parse($log->call_end_time))->format('%I:%S') }}<br>
                                @else
                                N/A<br>
                                @endif
                                @endforeach
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
                <div class="d-flex justify-content-between">
                    <div style="margin-left: 20px;">Total Records: {{ $onsiteVisits->total() }}</div> <!-- Add margin to the right of the total records count -->
                    <div style="margin-left: 20px;">{{ $onsiteVisits->links() }}</div> <!-- Add margin to the left of the pagination links -->
                </div>
            </div>
        </div>


    </div>
</div>