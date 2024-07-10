<?php

namespace App\Livewire\EditCustomer;

use Livewire\Component;
use App\Models\CustomerType;
use App\Models\MobileNumber;

class EditCustomerAddress extends Component
{
    public $addresses = [];
    public $addressTypes;
    public $primary_address_id;
    public $customer;

    protected $rules = [
        'addresses.*.customer_type_id' => 'required|exists:customer_types,id',
        'addresses.*.contact_person' => 'nullable|string|max:191',
        'addresses.*.mobile_no' => 'nullable|array',
        'addresses.*.phone_no' => 'nullable|string|max:191',
        'addresses.*.email' => 'nullable|email|max:191',
        'primary_address_id' => 'nullable|exists:address_books,address_id',
    ];

    public function mount($customer)
    {
        $this->customer = $customer;
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = $this->customer->addresses()->get()->map(function ($address) {
            return [
                'address_id' => $address->address_id,
                'customer_type_id' => $address->customer_type_id,
                'contact_person' => $address->contact_person,
                'mobile_no' => MobileNumber::where('address_id', $address->address_id)->pluck('mobile_no')->toArray(),
                'phone_no' => $address->phone_no,
                'email' => $address->email,
            ];
        })->toArray();
        $this->primary_address_id = $this->customer->primary_address_id;
    }

    public function saveAddresses()
    {
        $this->validate();

        foreach ($this->addresses as $address) {
            $addressData = [
                'customer_type_id' => $address['customer_type_id'],
                'contact_person' => $address['contact_person'],
                'phone_no' => $address['phone_no'],
                'email' => $address['email'],
                'customer_id' => $this->customer->id,
            ];

            $createdAddress = $this->customer->addresses()->updateOrCreate(
                ['address_id' => $address['address_id']],
                $addressData
            );

            MobileNumber::where('address_id', $createdAddress->address_id)->delete();
            foreach ($address['mobile_no'] as $mobileNo) {
                if (!empty($mobileNo)) {
                    MobileNumber::create([
                        'address_id' => $createdAddress->address_id,
                        'mobile_no' => $mobileNo,
                    ]);
                }
            }

            if ($address['address_id'] == $this->primary_address_id) {
                $this->primary_address_id = $createdAddress->address_id;
            }
        }

        if ($this->primary_address_id) {
            $this->customer->update(['primary_address_id' => $this->primary_address_id]);
        }

        $this->emit('addressesUpdated');
        session()->flash('message', 'Addresses updated successfully.');
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'address_id' => uniqid(),
            'customer_type_id' => '',
            'contact_person' => '',
            'mobile_no' => [''],
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
    }

    public function addMobileNo($addressIndex)
    {
        $this->addresses[$addressIndex]['mobile_no'][] = '';
    }

    public function removeMobileNo($addressIndex, $mobileIndex)
    {
        unset($this->addresses[$addressIndex]['mobile_no'][$mobileIndex]);
        $this->addresses[$addressIndex]['mobile_no'] = array_values($this->addresses[$addressIndex]['mobile_no']);
    }

    public function render()
    {
        return view('livewire.edit-customer.edit-customer-address');
    }
}
