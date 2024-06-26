<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\Addresstype;

class EditAddress extends Component
{
    public $addresses = [];
    public $addressTypes = [];
    public $customer_name;
    public $customer_id;

    public function mount($customerId)
    {
        $this->customer_id = $customerId;
        $this->customer_name = Customer::find($customerId)->customer_name;
        $this->addresses = AddressBook::where('customer_id', $customerId)->get()->toArray();
        $this->addressTypes = Addresstype::orderBy('name', 'asc')->get();
    }

    public function removeAddress($index)
    {
        $address = $this->addresses[$index];

        if (isset($address['address_id'])) {
            AddressBook::find($address['address_id'])->delete();
        }

        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
        session()->flash('message', 'Address deleted successfully.');
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'address_type_id' => null,
            'contact_person' => '',
            'mobile_no' => '',
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function update()
    {
        foreach ($this->addresses as $address) {
            if (isset($address['address_id'])) {
                // Update existing address
                AddressBook::find($address['address_id'])->update($address);
            } else {
                // Create new address
                AddressBook::create(array_merge($address, ['customer_id' => $this->customer_id]));
            }
        }
        session()->flash('message', 'Customer addresses updated successfully.');
    }

    public function render()
    {
        return view('livewire.edit-address', [
            'addresses' => $this->addresses,
            'addressTypes' => $this->addressTypes,
        ]);
    }
}
