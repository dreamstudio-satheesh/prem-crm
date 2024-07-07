<?php


namespace App\Livewire;

use Livewire\Component;
use App\Models\OnsiteVisit;
use App\Models\Customer;
use App\Models\AddressBook;

class CreateOnsiteVisit extends Component
{
    public $customer_id;
    public $contact_person_id;
    public $contact_person_mobile;
    public $type_of_call;
    public $call_start_time;
    public $call_end_time;
    public $status_of_call;
    public $service_charges;
    public $remarks;
    public $contactPersons = [];

    protected $rules = [
        'customer_id' => 'required|exists:customers,customer_id',
        'contact_person_id' => 'required|exists:address_books,address_id',
        'type_of_call' => 'required|string',
        'call_start_time' => 'required|date',
        'call_end_time' => 'nullable|date',
        'status_of_call' => 'required|in:completed,pending',
        'service_charges' => 'nullable|numeric',
        'remarks' => 'nullable|string',
    ];

    public function updatedCustomerId($value)
    {
        $this->contactPersons = AddressBook::where('customer_id', $value)->get();
    }

    public function updatedContactPersonId($value)
    {
        $this->contact_person_mobile = AddressBook::where('address_id', $value)->value('mobile_no');
    }

    public function submit()
    {
        $this->validate();

        OnsiteVisit::create([
            'customer_id' => $this->customer_id,
            'contact_person_id' => $this->contact_person_id,
            'type_of_call' => $this->type_of_call,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'status_of_call' => $this->status_of_call,
            'service_charges' => $this->service_charges,
            'remarks' => $this->remarks,
        ]);

        session()->flash('success', 'Onsite Visit Created Successfully.');

        return redirect()->route('onsite-visits.index');
    }

    public function render()
    {
        return view('livewire.create-onsite-visit', [
            'customers' => Customer::all(),
        ]);
    }
}
