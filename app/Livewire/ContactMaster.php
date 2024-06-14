<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\Hash;

class ContactMaster extends Component
{
    use WithPagination;

    public $contact_id;
    public $name, $phone, $email, $address, $company, $notes, $designation, $user_id;
    public $selected_customers = [];
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:contacts,phone',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'designation' => 'nullable|in:MD,Auditor,GSTP / Tax Consultant,Computer Service,Company Staff,others',
        'user_id' => 'nullable|exists:users,id',
    ];

    public function render()
    {
        $contacts = Contact::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('phone', 'like', '%'.$this->search.'%')
            ->orderBy('contact_id', 'desc')
            ->paginate(10);

        $customers = Customer::all();

        return view('livewire.contact-master', compact('contacts', 'customers'));
    }

    public function resetInputFields()
    {
        $this->contact_id = null;
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->company = '';
        $this->notes = '';
        $this->designation = '';
        $this->user_id = null;
        $this->selected_customers = [];
    }

    public function store()
    {
        $this->validate();

        $contact = Contact::updateOrCreate(
            ['contact_id' => $this->contact_id],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'company' => $this->company,
                'notes' => $this->notes,
                'designation' => $this->designation,
                'user_id' => $this->user_id,
            ]
        );

        // Clear previous assignments if editing
        if ($this->contact_id) {
            CustomerContact::where('contact_id', $contact->contact_id)->delete();
        }

        // Assign contact to selected customers
        if (!empty($this->selected_customers)) {
            foreach ($this->selected_customers as $customer_id) {
                CustomerContact::create([
                    'contact_id' => $contact->contact_id,
                    'customer_id' => $customer_id,
                    'role' => '' // Assign role as needed
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
        $this->phone = $contact->phone;
        $this->email = $contact->email;
        $this->address = $contact->address;
        $this->company = $contact->company;
        $this->notes = $contact->notes;
        $this->designation = $contact->designation;
        $this->user_id = $contact->user_id;
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
}
