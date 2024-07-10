<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;

class AMCStatus extends Component
{
    public $amc = 'no';
    public $amc_from_date;
    public $amc_to_date;
    public $amc_renewal_date;
    public $no_of_visits;
    public $amc_amount;
    public $amc_last_year_amount;

    protected $rules = [
        'amc' => 'required|in:yes,no',
        'amc_from_date' => 'nullable|date',
        'amc_to_date' => 'nullable|date',
        'amc_renewal_date' => 'nullable|date',
        'no_of_visits' => 'nullable|integer',
        'amc_amount' => 'nullable|numeric',
        'amc_last_year_amount' => 'nullable|numeric',
    ];

    public function save()
    {
        $this->validate();
        $this->emit('amcStatusSaved', [
            'amc' => $this->amc,
            'amc_from_date' => $this->amc_from_date,
            'amc_to_date' => $this->amc_to_date,
            'amc_renewal_date' => $this->amc_renewal_date,
            'no_of_visits' => $this->no_of_visits,
            'amc_amount' => $this->amc_amount,
            'amc_last_year_amount' => $this->amc_last_year_amount,
        ]);
    }

    public function render()
    {
        return view('livewire.add-customer.amc-status');
    }
}

