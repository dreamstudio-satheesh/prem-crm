<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\ContactPhone;
use App\Models\Position;

class ContactMaster extends Component
{
    use WithPagination;

    public $contact_id;
    public $name, $email, $address, $company, $notes, $position_id, $user_id;
    public $selected_customers = [];
    public $search = '';
    public $phone_numbers = [];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'position_id' => 'required|exists:positions,position_id',
        'user_id' => 'nullable|exists:users,id',
        'phone_numbers.*.number' => 'required|string|max:20',
        'phone_numbers.*.type' => 'required|in:mobile,phone',
    ];

    public function render()
    {
        $contacts = Contact::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('contact_id', 'desc')
            ->paginate(10);

        $customers = Customer::all();
        $positions = Position::all();

        return view('livewire.contact-master', compact('contacts', 'customers', 'positions'));
    }

    public function resetInputFields()
    {
        $this->contact_id = null;
        $this->name = '';
        $this->email = '';
        $this->address = '';
        $this->company = '';
        $this->notes = '';
        $this->position_id = null;
        $this->user_id = null;
        $this->phone_numbers = [];
        $this->selected_customers = [];
    }

    public function store()
    {
        $this->validate();

        $contact = Contact::updateOrCreate(
            ['contact_id' => $this->contact_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
                'company' => $this->company,
                'notes' => $this->notes,
                'position_id' => $this->position_id,
                'user_id' => $this->user_id,
            ]
        );

        // Clear previous phone numbers if editing
        if ($this->contact_id) {
            ContactPhone::where('contact_id', $contact->contact_id)->delete();
        }

        // Store phone numbers
        foreach ($this->phone_numbers as $phone) {
            ContactPhone::create([
                'contact_id' => $contact->contact_id,
                'phone_number' => $phone['number'],
                'phone_type' => $phone['type'],
            ]);
        }

        // Clear previous customer assignments if editing
        if ($this->contact_id) {
            CustomerContact::where('contact_id', $contact->contact_id)->delete();
        }

        // Assign contact to selected customers
        if (!empty($this->selected_customers)) {
            foreach ($this->selected_customers as $customer_id) {
                CustomerContact::create([
                    'contact_id' => $contact->contact_id,
                    'customer_id' => $customer_id,
                ]);
            }
        }

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Contact '.($this->contact_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $this->contact_id = $contact->contact_id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->address = $contact->address;
        $this->company = $contact->company;
        $this->notes = $contact->notes;
        $this->position_id = $contact->position_id;
        $this->user_id = $contact->user_id;
        $this->phone_numbers = ContactPhone::where('contact_id', $id)->get(['phone_number as number', 'phone_type as type'])->toArray();
        $this->selected_customers = CustomerContact::where('contact_id', $id)->pluck('customer_id')->toArray();
    }

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
        CustomerContact::where('contact_id', $id)->delete();
        $this->dispatch('show-toastr', ['message' => 'Contact Deleted Successfully.']);
    }

    public function create()
    {
        $this->resetInputFields();
    }

    public function addPhoneNumber()
    {
        $this->phone_numbers[] = ['number' => '', 'type' => 'mobile'];
    }

    public function removePhoneNumber($index)
    {
        unset($this->phone_numbers[$index]);
        $this->phone_numbers = array_values($this->phone_numbers);
    }
}
