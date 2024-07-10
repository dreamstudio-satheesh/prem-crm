<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;

class TSSStatus extends Component
{
    public $tss_status = 'inactive';
    public $tss_adminemail;
    public $tss_expirydate;

    protected $rules = [
        'tss_status' => 'required|in:active,inactive',
        'tss_adminemail' => 'nullable|email|max:191',
        'tss_expirydate' => 'nullable|date',
    ];

    public function save()
    {
        $this->validate();
        $this->emit('tssStatusSaved', [
            'tss_status' => $this->tss_status,
            'tss_adminemail' => $this->tss_adminemail,
            'tss_expirydate' => $this->tss_expirydate,
        ]);
    }

    public function render()
    {
        return view('livewire.add-customer.tss-status');
    }
}

