<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\MobileNumber;

class AddCustomer extends Component
{
    public $customerDetails = [];
    public $addresses = [];
    public $tssStatus = [];
    public $amcStatus = [];
    public $otherSettings = [];

    protected $listeners = [
        'customerDetailsSaved' => 'handleCustomerDetailsSaved',
        'customerAddressSaved' => 'handleCustomerAddressSaved',
        'tssStatusSaved' => 'handleTSSStatusSaved',
        'amcStatusSaved' => 'handleAMCStatusSaved',
        'otherSettingsSaved' => 'handleOtherSettingsSaved',
    ];

    public function handleCustomerDetailsSaved($data)
    {
        $this->customerDetails = $data;
    }

    public function handleCustomerAddressSaved($data)
    {
        $this->addresses = $data;
    }

    public function handleTSSStatusSaved($data)
    {
        $this->tssStatus = $data;
    }

    public function handleAMCStatusSaved($data)
    {
        $this->amcStatus = $data;
    }

    public function handleOtherSettingsSaved($data)
    {
        $this->otherSettings = $data;
    }

    public function save()
    {
        $this->validate();

        $customer = Customer::create(array_merge(
            $this->customerDetails,
            $this->tssStatus,
            $this->otherSettings
        ));

        if ($this->amcStatus['amc'] === 'yes') {
            $customer->amc()->create($this->amcStatus);
        }

        $primaryAddressId = null;
        if ($this->addresses) {
            foreach ($this->addresses as $index => $address) {
                $addressData = [
                    'customer_type_id' => $address['customer_type_id'],
                    'contact_person' => $address['contact_person'],
                    'phone_no' => $address['phone_no'],
                    'email' => $address['email'],
                    'customer_id' => $customer->id,
                ];

                $createdAddress = AddressBook::create($addressData);

                foreach ($address['mobile_no'] as $mobileNo) {
                    if (!is_null($mobileNo) && $mobileNo !== '') {
                        MobileNumber::create([
                            'address_id' => $createdAddress->id,
                            'mobile_no' => $mobileNo,
                        ]);
                    }
                }

                if ($index === 0) {
                    $primaryAddressId = $createdAddress->id;
                }
            }
        }

        if ($primaryAddressId) {
            $customer->update(['primary_address_id' => $primaryAddressId]);
        }

        session()->flash('message', 'Customer added successfully.');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.add-customer.add-customer');
    }
}

