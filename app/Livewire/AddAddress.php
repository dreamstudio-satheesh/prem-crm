<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AddressBook;
use App\Models\CustomerType;
use App\Models\Customer;
use App\Models\MobileNumber;

class AddAddress extends Component
{
    public $customer_id;
    public $customer_name;
    public $addresses = [];
    public $addressTypes;

    protected $rules = [
        'addresses.*.customer_type_id' => 'required',
        'addresses.*.contact_person' => 'required|string|max:255',
        'addresses.*.mobile_no' => 'required|array|min:1',
        'addresses.*.mobile_no.*' => 'nullable|numeric',
        'addresses.*.phone_no' => 'nullable|numeric',
        'addresses.*.email' => 'nullable|email|max:255',
    ];

    public function mount($customerId)
    {
        $this->customer_id = $customerId;
        $customer = Customer::find($customerId);
        $this->customer_name = $customer->customer_name;
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
        $this->addresses[] = $this->getEmptyAddress();
    }

    public function getEmptyAddress()
    {
        return [
            'customer_type_id' => '',
            'contact_person' => '',
            'mobile_no' => [''], // Initialize with one empty mobile number
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

    public function addMobileNumber($index)
    {
        $this->addresses[$index]['mobile_no'][] = ''; // Add a new empty mobile number field
    }

    public function removeMobileNumber($addressIndex, $mobileIndex)
    {
        unset($this->addresses[$addressIndex]['mobile_no'][$mobileIndex]);
        $this->addresses[$addressIndex]['mobile_no'] = array_values($this->addresses[$addressIndex]['mobile_no']);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->addresses as $index => $address) {
            $addressBook = AddressBook::create([
                'index' => $index + 1,
                'customer_id' => $this->customer_id, // Ensure customer_id is set
                'customer_type_id' => $address['customer_type_id'],
                'contact_person' => $address['contact_person'],
                'phone_no' => $address['phone_no'],
                'email' => $address['email'],
            ]);

            foreach ($address['mobile_no'] as $mobileNo) {
                if (!is_null($mobileNo) && $mobileNo !== '') { // Check if mobile number is not null or empty
                    MobileNumber::create([
                        'address_id' => $addressBook->address_id,
                        'mobile_no' => $mobileNo,
                    ]);
                }
            }
        }

        session()->flash('message', 'Customer Address created successfully!');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.add-address');
    }
}
