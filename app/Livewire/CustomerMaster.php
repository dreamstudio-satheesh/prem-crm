<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class CustomerMaster extends Component
{
    use WithPagination;

    public $customer_id;
    public $customer_name, $mobile_number, $email_id, $company_name, $tally_no, $tally_version, $contact_info;
    public $city, $address, $designation,  $lat, $lng, $whatsapp_telegram_group = false;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'mobile_number' => 'required|string|max:15',
        'email_id' => 'nullable|email|max:255',
        'company_name' => 'nullable|string|max:255',
        'tally_no' => 'nullable|string|max:255',
        'tally_version' => 'nullable|string|max:255',
        'contact_info' => 'nullable|json',
        'city' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:1000',
        'designation' => 'nullable|in:Owner,Accounts Manager,Accountant,Auditor,TAX Consultant',
        'lat' => 'nullable',
        'lng' => 'nullable',
        'whatsapp_telegram_group' => 'boolean',
    ];

    public function render()
    {
        $customers = Customer::where('customer_name', 'like', '%'.$this->search.'%')
            ->orderBy('customer_id', 'desc')
            ->paginate(10);

        return view('livewire.customer-master', compact('customers'));
    }

    public function resetInputFields()
    {
        $this->customer_id = null;
        $this->customer_name = '';
        $this->mobile_number = '';
        $this->email_id = '';
        $this->company_name = '';
        $this->tally_no = '';
        $this->tally_version = '';
        $this->contact_info = '';
        $this->city = '';
        $this->address = '';
        $this->designation = '';
        $this->lat = '';
        $this->lng = '';
        $this->whatsapp_telegram_group = false;
    }

    public function store()
    {
        $this->validate();
        
        Customer::updateOrCreate(['customer_id' => $this->customer_id], [
            'customer_name' => $this->customer_name,
            'mobile_number' => $this->mobile_number,
            'email_id' => $this->email_id,
            'company_name' => $this->company_name,
            'tally_no' => $this->tally_no,
            'tally_version' => $this->tally_version,
            'contact_info' => $this->contact_info,
            'city' => $this->city,
            'address' => $this->address,
            'designation' => $this->designation,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
        ]);

        session()->flash('success', 'Customer '.($this->customer_id ? 'Updated' : 'Created').' Successfully.');

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Customer '.($this->customer_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customer_id = $customer->customer_id;
        $this->customer_name = $customer->customer_name;
        $this->mobile_number = $customer->mobile_number;
        $this->email_id = $customer->email_id;
        $this->company_name = $customer->company_name;
        $this->tally_no = $customer->tally_no;
        $this->tally_version = $customer->tally_version;
        $this->contact_info = $customer->contact_info;
        $this->city = $customer->city;
        $this->address = $customer->address;
        $this->designation = $customer->designation;
        $this->lat = $customer->lat;
        $this->lng = $customer->lng;
        $this->whatsapp_telegram_group = $customer->whatsapp_telegram_group;
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        session()->flash('success', 'Customer Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
