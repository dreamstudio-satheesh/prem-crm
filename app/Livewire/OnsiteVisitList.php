<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OnsiteVisit;

class OnsiteVisitList extends Component
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
        $onsiteVisits = OnsiteVisit::with(['customer', 'contactPerson'])
            ->whereHas('customer', function($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.onsite-visit-list', ['onsiteVisits' => $onsiteVisits]);
    }
}
