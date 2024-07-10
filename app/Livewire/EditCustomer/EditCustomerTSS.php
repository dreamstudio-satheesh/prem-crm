<?php

namespace App\Livewire\EditCustomer;

use Livewire\Component;

class EditCustomerTSS extends Component
{
    public $tss_status;
    public $tss_adminemail;
    public $tss_expirydate;

    protected $rules = [
        'tss_status' => 'required|in:active,inactive',
        'tss_adminemail' => 'nullable|email|max:191',
        'tss_expirydate' => 'nullable|date',
    ];

    public function mount($customer)
    {
        $this->fill($customer->only(['tss_status', 'tss_adminemail', 'tss_expirydate']));
    }

    public function save()
    {
        $this->validate();

        $this->emit('updateCustomerTSS', [
            'tss_status' => $this->tss_status,
            'tss_adminemail' => $this->tss_adminemail,
            'tss_expirydate' => $this->tss_expirydate,
        ]);
    }

    public function render()
    {
        return view('livewire.edit-customer.edit-customer-tss');
    }
}
