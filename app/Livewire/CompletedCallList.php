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
            $query->where('type_of_call', $this->callType);
        }

        if ($this->search) {
            $query->whereHas('customer', function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            });
        }

        // Log the query and bindings
        Log::info('CompletedCallList Query: ' . $query->toSql(), $query->getBindings());

        // Log the count of the results
        $resultCount = $query->count();
        Log::info('Filtered Results Count: ' . $resultCount);

        $onsiteVisits = $query->paginate(10);

        return view('livewire.completed-call-list', ['onsiteVisits' => $onsiteVisits]);
    }
}
