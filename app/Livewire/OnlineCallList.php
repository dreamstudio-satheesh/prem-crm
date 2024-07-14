<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceCall;

class OnlineCallList extends Component
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
        $onlineCalls = ServiceCall::where('call_type','online_call')->with(['customer', 'contactPerson.mobileNumbers'])
            ->whereHas('customer', function($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })->paginate(100);

        return view('livewire.online-call-list', ['onlineCalls' => $onlineCalls]);
    }
}
