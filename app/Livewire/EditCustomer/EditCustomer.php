<?php

namespace App\Livewire\EditCustomer;

use Livewire\Component;
use App\Models\Customer;

class EditCustomer extends Component
{
    public $customer;

    protected $listeners = [
        'updateCustomerDetails' => 'updateCustomerDetails',
        'updateCustomerAddress' => 'updateCustomerAddress',
        'updateCustomerTSS' => 'updateCustomerTSS',
        'updateCustomerAMC' => 'updateCustomerAMC',
        'updateCustomerFeatures' => 'updateCustomerFeatures',
    ];

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function updateCustomerDetails($data)
    {
        $this->customer->update($data);
        session()->flash('message', 'Customer details updated successfully.');
    }

    public function updateCustomerAddress($data)
    {
        // Handle address update logic
        session()->flash('message', 'Customer addresses updated successfully.');
    }

    public function updateCustomerTSS($data)
    {
        $this->customer->update($data);
        session()->flash('message', 'Customer TSS updated successfully.');
    }

    public function updateCustomerAMC($data)
    {
        $this->customer->update($data);
        session()->flash('message', 'Customer AMC updated successfully.');
    }

    public function updateCustomerFeatures($data)
    {
        $this->customer->update($data);
        session()->flash('message', 'Customer features updated successfully.');
    }

    public function render()
    {
        return view('livewire.edit-customer.edit-customer', ['customer' => $this->customer]);
    }
}
