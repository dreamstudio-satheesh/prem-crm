<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceCall;

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

        $onsiteVisits = $query->whereHas('customer', function ($query) {
            $query->where('customer_name', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.completed-call-list', ['onsiteVisits' => $onsiteVisits]);
    }
}
