<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;
use App\Models\CustomerType;
use App\Models\AddressBook;
use App\Models\MobileNumber;

class CustomerAddress extends Component
{
    public $addresses = [];
    public $addressTypes;

    protected $rules = [
        'addresses.*.customer_type_id' => 'required|exists:customer_types,id',
        'addresses.*.contact_person' => 'nullable|string|max:191',
        'addresses.*.mobile_no' => 'nullable|array',
        'addresses.*.phone_no' => 'nullable|string|max:191',
        'addresses.*.email' => 'nullable|email|max:191',
    ];

    public function mount()
    {
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
        $this->addAddress();
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'customer_type_id' => '',
            'contact_person' => '',
            'mobile_no' => [''],
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function addMobileNumber($index)
    {
        $this->addresses[$index]['mobile_no'][] = '';
    }

    public function removeMobileNumber($addressIndex, $mobileIndex)
    {
        unset($this->addresses[$addressIndex]['mobile_no'][$mobileIndex]);
        $this->addresses[$addressIndex]['mobile_no'] = array_values($this->addresses[$addressIndex]['mobile_no']);
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
    }

    public function save()
    {
        $this->validate();
        $this->emit('customerAddressSaved', $this->addresses);
    }

    public function render()
    {
        return view('livewire.add-customer.customer-address');
    }
}

