<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;

class AddCustomer extends Component
{
    public $customer_name;
    public $tally_serial_no;
    public $licence_editon;
    public $primary_address_id;
    public $default_customer_type_id;
    public $product_id;
    public $locations_id;
    public $staff_id;
    public $amc = 'no';
    public $tss_status = 'inactive';
    public $tss_adminemail;
    public $tss_expirydate;
    public $profile_status;
    public $remarks;
    public $whatsapp_telegram_group;
    public $tdl_addons;
    public $auto_backup = false;
    public $cloud_user = false;
    public $mobile_app = false;
    public $gst_no;
    public $map_location;

     // AMC fields
     public $amc_from_date;
     public $amc_to_date;
     public $amc_renewal_date;
     public $no_of_visits;
     public $amc_amount;
     public $amc_last_year_amount;

    protected $rules = [
        'customer_name' => 'required|string|max:191',
        'tally_serial_no' => 'nullable|string|max:191',
        'licence_editon' => 'nullable|string|max:191',
        'primary_address_id' => 'nullable|exists:address_books,address_id',
        'default_customer_type_id' => 'required|exists:customer_types,id',
        'product_id' => 'nullable|exists:products,id',
        'locations_id' => 'nullable|exists:locations,id',
        'staff_id' => 'nullable|exists:users,id',
        'amc' => 'required|in:yes,no',
        'tss_status' => 'required|in:active,inactive',
        'tss_adminemail' => 'nullable|email|max:191',
        'tss_expirydate' => 'nullable|date',
        'profile_status' => 'nullable|in:Followup,Others',
        'remarks' => 'nullable|string|max:191',
        'whatsapp_telegram_group' => 'nullable|boolean',
        'tdl_addons' => 'nullable|string|max:191',
        'auto_backup' => 'nullable|boolean',
        'cloud_user' => 'nullable|boolean',
        'mobile_app' => 'nullable|boolean',
        'gst_no' => 'nullable|string|max:191',
        'map_location' => 'nullable|string|max:191',

        // AMC validation rules
        'amc_from_date' => 'nullable|date',
        'amc_to_date' => 'nullable|date',
        'amc_renewal_date' => 'nullable|date',
        'no_of_visits' => 'nullable|integer',
        'amc_amount' => 'nullable|numeric',
        'amc_last_year_amount' => 'nullable|numeric',
    ];

    public function save()
    {
        $this->validate();

        $customer=Customer::create([
            'customer_name' => $this->customer_name,
            'tally_serial_no' => $this->tally_serial_no,
            'primary_address_id' => $this->primary_address_id,
            'default_customer_type_id' => $this->default_customer_type_id,
            'products_id' => $this->product_id,
            'locations_id' => $this->locations_id,
            'staff_id' => $this->staff_id,
            'amc' => $this->amc,
            'tss_status' => $this->tss_status,
            'tss_adminemail' => $this->tss_adminemail,
            'tss_expirydate' => $this->tss_expirydate,
            'profile_status' => $this->profile_status,
            'remarks' => $this->remarks,
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
            'tdl_addons' => $this->tdl_addons,
            'auto_backup' => $this->auto_backup,
            'cloud_user' => $this->cloud_user,
            'mobile_app' => $this->mobile_app,
            'gst_no' => $this->gst_no,
            'map_location' => $this->map_location,
        ]);

        if ($this->amc === 'yes') {
            $customer->amc()->create([
                'amc_from_date' => $this->amc_from_date,
                'amc_to_date' => $this->amc_to_date,
                'amc_renewal_date' => $this->amc_renewal_date,
                'no_of_visits' => $this->no_of_visits,
                'amc_amount' => $this->amc_amount,
                'amc_last_year_amount' => $this->amc_last_year_amount,
            ]);
        }

        session()->flash('message', 'Customer added successfully.');
        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.add-customer', [
            'products' => Product::all(),
            'users' => User::all(),
        ])->extends('layouts.admin')->section('content');
    }
}
