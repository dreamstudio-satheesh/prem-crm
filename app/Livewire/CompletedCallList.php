<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceCall;

class CompletedCallList extends Component
{
    use WithPagination;

    public $search = '';
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
        $onsiteVisits = ServiceCall::whereIn('status_of_call', ['cancelled', 'completed'])
            ->with(['customer', 'contactPerson.mobileNumbers'])
            ->whereHas('customer', function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

            dd($onsiteVisits);

        return view('livewire.completed-call-list', ['onsiteVisits' => $onsiteVisits]);
    }

    /* public function render()
    {
        $onsiteVisits = ServiceCall::where('call_type', 'onsite_visit')
            ->with(['customer', 'contactPerson', 'serviceCallLogs'])
            ->whereHas('customer', function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.onsite-visit-list', ['onsiteVisits' => $onsiteVisits]);
    } */
}
