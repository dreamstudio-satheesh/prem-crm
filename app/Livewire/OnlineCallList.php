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
        $onlineCalls = ServiceCall::where('call_type', 'online_call')
            ->whereNotIn('status_of_call', ['cancelled', 'completed'])
            ->with(['customer', 'contactPerson.mobileNumbers'])
            ->whereHas('customer', function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

            $onlineCalls->each(function ($call) {
                // Assume "On Process" if last activity was within the last 5 minutes
                if ($call->last_activity_time && $call->last_activity_time->gt(now()->subMinutes(5))) {
                    $call->status_of_call = "On Process";
                }

                return $call;
            });



        return view('livewire.online-call-list', ['onlineCalls' => $onlineCalls]);
    }
}
