<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AddressBook;
use App\Models\Customertype;
use App\Models\Customer;

class AddAddress extends Component
{
    public $customer_id;
    public $customer_name;
    public $addresses = [];
    public $addressTypes;

    protected $rules = [
        'addresses.*.address_type_id' => 'required',
        'addresses.*.contact_person' => 'required|string|max:255',
        'addresses.*.mobile_no' => 'required|numeric',
        'addresses.*.phone_no' => 'nullable|numeric',
        'addresses.*.email' => 'nullable|email|max:255',
    ];

    public function mount($customerId)
    {
        $this->customer_id = $customerId;
        $customer = Customer::find($customerId);
        $this->customer_name = $customer->customer_name;
        $this->addressTypes = Customertype::orderBy('name', 'asc')->get();
        $this->addresses[] = $this->getEmptyAddress();
    }

    public function getEmptyAddress()
    {
        return [
            'address_type_id' => '',
            'contact_person' => '',
            'mobile_no' => '',
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function addAddress()
    {
        $this->addresses[] = $this->getEmptyAddress();
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->addresses as $index => $address) {
            AddressBook::create([
                'index' => $index + 1,
                'customer_id' => $this->customer_id, // Ensure customer_id is set
                'address_type_id' => $address['address_type_id'],
                'contact_person' => $address['contact_person'],
                'mobile_no' => $address['mobile_no'],
                'phone_no' => $address['phone_no'],
                'email' => $address['email'],
            ]);
        }

        session()->flash('message', 'Customer Address created successfully!');
        return redirect()->route('customers');
    }



    public function render()
    {
        return view('livewire.add-address');
    }
}
