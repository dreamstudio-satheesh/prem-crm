<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ServiceCall;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class CompletedCallList extends Component
{
    use WithPagination;

    public $search = '';
    public $callType = '';

    public $startDate = null; 
    public $endDate = null; 
    
    public $showFilters = false;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function render()
    {
        $query = ServiceCall::whereIn('status_of_call', ['cancelled', 'completed'])
            ->with(['customer', 'contactPerson.mobileNumbers', 'serviceCallLogs']);

        if ($this->callType) {
            $query->where('call_type', $this->callType); // Corrected column name
        }

        if ($this->search) {
            $query->whereHas('customer', function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            });
        }

        // Date filtering
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('call_booking_time', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->whereDate('call_booking_time', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->whereDate('call_booking_time', '<=', $this->endDate);
        }

        $onsiteVisits = $query->paginate(10);

        return view('livewire.completed-call-list', ['onsiteVisits' => $onsiteVisits]);
    }
}
