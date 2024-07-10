<?php

namespace App\Livewire\EditCustomer;

use Livewire\Component;
use App\Models\Product;
use App\Models\Licence;
use App\Models\Location;
use App\Models\User;

class EditCustomerDetails extends Component
{
    public $customer_name;
    public $tally_serial_no;
    public $licence_editon_id;
    public $product_id;
    public $location_id;
    public $staff_id;
    public $profile_status;
    public $remarks;

    public $products;
    public $licences;
    public $locations;
    public $users;

    protected $rules = [
        'customer_name' => 'required|string|max:191',
        'tally_serial_no' => 'nullable|string|max:191',
        'licence_editon_id' => 'nullable|exists:licences,id',
        'product_id' => 'nullable|exists:products,id',
        'location_id' => 'nullable|exists:locations,id',
        'staff_id' => 'nullable|exists:users,id',
        'profile_status' => 'nullable|in:Followup,Others',
        'remarks' => 'nullable|string|max:191',
    ];

    public function mount($customer)
    {
        $this->fill($customer->only([
            'customer_name', 'tally_serial_no', 'licence_editon_id', 'product_id', 'location_id', 'staff_id', 'profile_status', 'remarks'
        ]));

        $this->products = Product::all();
        $this->licences = Licence::all();
        $this->locations = Location::all();
        $this->users = User::all();
    }

    public function save()
    {
        $this->validate();

        $this->emit('updateCustomerDetails', [
            'customer_name' => $this->customer_name,
            'tally_serial_no' => $this->tally_serial_no,
            'licence_editon_id' => $this->licence_editon_id,
            'product_id' => $this->product_id,
            'location_id' => $this->location_id,
            'staff_id' => $this->staff_id,
            'profile_status' => $this->profile_status,
            'remarks' => $this->remarks,
        ]);
    }

    public function render()
    {
        return view('livewire.edit-customer.edit-customer-details', [
            'products' => $this->products,
            'licences' => $this->licences,
            'locations' => $this->locations,
            'users' => $this->users,
        ]);
    }
}
