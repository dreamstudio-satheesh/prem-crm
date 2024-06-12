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
    public $city, $address, $designation, $type_of_call, $lat, $lng, $tss_status, $tss_expiry;
    public $auto_cloud_backup_tdl_module = false, $whatsapp_telegram_group = false;
    public $call_start_time, $call_end_time, $total_hours_spent, $status_of_the_call, $service_charges;
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
        'type_of_call' => 'nullable|string|max:255',
        'lat' => 'nullable',
        'lng' => 'nullable',
        'tss_status' => 'required|in:Active,Not Active',
        'tss_expiry' => 'nullable|date',
        'auto_cloud_backup_tdl_module' => 'boolean',
        'whatsapp_telegram_group' => 'boolean',
        'call_start_time' => 'nullable|date',
        'call_end_time' => 'nullable|date',
        'total_hours_spent' => 'nullable|numeric',
        'status_of_the_call' => 'required|in:Pending,Completed,Cancelled',
        'service_charges' => 'nullable|numeric',
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
        $this->type_of_call = '';
        $this->lat = '';
        $this->lng = '';
        $this->tss_status = 'Active';
        $this->tss_expiry = null;
        $this->auto_cloud_backup_tdl_module = false;
        $this->whatsapp_telegram_group = false;
        $this->call_start_time = null;
        $this->call_end_time = null;
        $this->total_hours_spent = null;
        $this->status_of_the_call = 'Pending';
        $this->service_charges = null;
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
            'type_of_call' => $this->type_of_call,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'tss_status' => $this->tss_status,
            'tss_expiry' => $this->tss_expiry,
            'auto_cloud_backup_tdl_module' => $this->auto_cloud_backup_tdl_module,
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'total_hours_spent' => $this->total_hours_spent,
            'status_of_the_call' => $this->status_of_the_call,
            'service_charges' => $this->service_charges,
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
        $this->type_of_call = $customer->type_of_call;
        $this->lat = $customer->lat;
        $this->lng = $customer->lng;
        $this->tss_status = $customer->tss_status;
        $this->tss_expiry = $customer->tss_expiry;
        $this->auto_cloud_backup_tdl_module = $customer->auto_cloud_backup_tdl_module;
        $this->whatsapp_telegram_group = $customer->whatsapp_telegram_group;
        $this->call_start_time = $customer->call_start_time;
        $this->call_end_time = $customer->call_end_time;
        $this->total_hours_spent = $customer->total_hours_spent;
        $this->status_of_the_call = $customer->status_of_the_call;
        $this->service_charges = $customer->service_charges;
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
