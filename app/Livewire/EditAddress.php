<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AddressBook;
use App\Models\CustomerType;
use App\Models\Customer;
use App\Models\MobileNumber;

class EditAddress extends Component
{
    public $addresses = [];
    public $addressTypes = [];
    public $customer_name;
    public $customer_id;
    public $primary_address_id;

    protected $rules = [
        'addresses.*.customer_type_id' => 'required|exists:customer_types,id',
        'addresses.*.contact_person' => 'required|string|max:255',
        'addresses.*.mobile_no' => 'required|array|min:1',
        'addresses.*.mobile_no.*' => 'required|string|max:15',
        'addresses.*.phone_no' => 'nullable|string|max:15',
        'addresses.*.email' => 'nullable|email|max:255',
        'primary_address_id' => 'nullable|exists:address_books,address_id',
    ];

    public function mount($customerId)
    {
        $this->customer_id = $customerId;
        $this->customer_name = Customer::find($customerId)->customer_name;
        $this->addresses = AddressBook::where('customer_id', $customerId)->get()->map(function ($address) {
            return [
                'id' => $address->address_id,
                'customer_type_id' => $address->customer_type_id,
                'contact_person' => $address->contact_person,
                'mobile_no' => MobileNumber::where('address_id', $address->address_id)->pluck('mobile_no')->toArray(),
                'phone_no' => $address->phone_no,
                'email' => $address->email,
            ];
        })->toArray();
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'id' => uniqid(),
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

    public function save()
    {
        $this->validate();

        foreach ($this->addresses as $address) {
            if (isset($address['id'])) {
                $existingAddress = AddressBook::find($address['id']);
                if ($existingAddress) {
                    $existingAddress->update($address);
                    MobileNumber::where('address_id', $existingAddress->address_id)->delete();
                    foreach ($address['mobile_no'] as $mobileNo) {
                        if (!empty($mobileNo)) {
                            MobileNumber::create([
                                'address_id' => $existingAddress->address_id,
                                'mobile_no' => $mobileNo,
                            ]);
                        }
                    }
                }
            } else {
                $newAddress = AddressBook::create(array_merge($address, ['customer_id' => $this->customer_id]));
                foreach ($address['mobile_no'] as $mobileNo) {
                    if (!empty($mobileNo)) {
                        MobileNumber::create([
                            'address_id' => $newAddress->address_id,
                            'mobile_no' => $mobileNo,
                        ]);
                    }
                }
            }
        }

        session()->flash('message', 'Customer Address updated successfully.');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.edit-address');
    }
}
