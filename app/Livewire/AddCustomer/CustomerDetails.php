<?php

namespace App\Livewire\AddCustomer;

use Livewire\Component;
use App\Models\Product;
use App\Models\Licence;
use App\Models\Location;
use App\Models\User;

class CustomerDetails extends Component
{
    public $products;
    public $locations;
    public $licences;
    public $users;

    public $customer_name;
    public $tally_serial_no;
    public $licence_editon_id;
    public $product_id;
    public $location_id;
    public $staff_id;
    public $profile_status;
    public $remarks;
    public $gst_no;
    public $map_location;
    public $latitude;
    public $longitude;

    protected $rules = [
        'customer_name' => 'required|string|max:191',
        'tally_serial_no' => 'nullable|string|max:191',
        'licence_editon_id' => 'nullable|exists:licences,id',
        'product_id' => 'nullable|exists:products,id',
        'location_id' => 'nullable|exists:locations,id',
        'staff_id' => 'nullable|exists:users,id',
        'profile_status' => 'nullable|in:Followup,Others',
        'remarks' => 'nullable|string|max:191',
        'gst_no' => 'nullable|string|max:191',
        'map_location' => 'nullable|string|max:191',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ];

    public function mount()
    {
        $this->products = Product::all();
        $this->locations = Location::all();
        $this->licences = Licence::all();
        $this->users = User::all();
    }

    public function save()
    {
        $this->validate();
        $this->emit('customerDetailsSaved', [
            'customer_name' => $this->customer_name,
            'tally_serial_no' => $this->tally_serial_no,
            'licence_editon_id' => $this->licence_editon_id,
            'product_id' => $this->product_id,
            'location_id' => $this->location_id,
            'staff_id' => $this->staff_id,
            'profile_status' => $this->profile_status,
            'remarks' => $this->remarks,
            'gst_no' => $this->gst_no,
            'map_location' => $this->map_location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
    }

    public function render()
    {
        return view('livewire.add-customer.customer-details');
    }
}
