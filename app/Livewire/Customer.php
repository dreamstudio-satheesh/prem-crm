<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer as CustomerModel;
use App\Models\Contact;
use App\Models\ContactPhone;

class Customer extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $customerId, $customer_name, $email_id, $phone, $company_name, $status, $primary_contact_id;
    public $editMode = false;
    public $selected = [];
    public $selectAll = false;
    public $search = '';
    public $statusFilter = 'all';

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'email_id' => 'required|email',
        'phone' => 'required|string|max:15',
        'company_name' => 'required|string|max:255',
        'status' => 'required|string|in:active,block'
    ];

    public function render()
    {
        $query = CustomerModel::query();

        if ($this->search) {
            $query->where('customer_name', 'like', '%' . $this->search . '%')
                ->orWhere('email_id', 'like', '%' . $this->search . '%')
                ->orWhere('company_name', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.customer', [
            'customers' => $query->paginate(10)
        ]);
    }

    public function store()
    {
        $this->validate();

        // Create Contact
        $contact = Contact::create([
            'name' => $this->customer_name,
            'email' => $this->email_id,
            'position_id' => 1,
            'company' => $this->company_name,
        ]);

        // Create Contact Phone
        ContactPhone::create([
            'contact_id' => $contact->contact_id,
            'phone_number' => $this->phone,
            'phone_type' => 'mobile',
        ]);

        // Create Customer
        CustomerModel::create([
            'customer_name' => $this->customer_name,
            'primary_contact_id' => $contact->contact_id,
            'email_id' => $this->email_id,
            'company_name' => $this->company_name,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $this->editMode = true;
        $customer = CustomerModel::findOrFail($id);
        $this->customerId = $customer->customer_id;
        $this->customer_name = $customer->customer_name;
        $this->email_id = $customer->email_id;
        $this->phone = $customer->primaryContact->phones->first()->phone_number ?? '';
        $this->company_name = $customer->company_name;
        $this->status = $customer->status;
        $this->primary_contact_id = $customer->primary_contact_id;

        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate();

        $customer = CustomerModel::findOrFail($this->customerId);
        $contact = Contact::findOrFail($this->primary_contact_id);

        // Update Contact
        $contact->update([
            'name' => $this->customer_name,
            'email' => $this->email_id,
            'position_id' => 1,
            'company' => $this->company_name,
        ]);

        // Update Contact Phone
        if ($contact->phones->isEmpty()) {
            ContactPhone::create([
                'contact_id' => $contact->contact_id,
                'phone_number' => $this->phone,
                'phone_type' => 'mobile',
            ]);
        } else {
            $contact->phones->first()->update([
                'phone_number' => $this->phone,
                'phone_type' => 'mobile',
            ]);
        }

        // Update Customer
        $customer->update([
            'customer_name' => $this->customer_name,
            'primary_contact_id' => $contact->contact_id,
            'email_id' => $this->email_id,
            'company_name' => $this->company_name,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->customerId = $id;
        $this->dispatch('showDeleteModal');
    }

    public function delete()
    {
        $customer = CustomerModel::findOrFail($this->customerId);
        $customer->delete();
        Contact::findOrFail($customer->primary_contact_id)->delete();

        $this->resetForm();
        $this->dispatch('closeDeleteModal');
    }

    public function deleteSelected()
    {
        foreach ($this->selected as $id) {
            $customer = CustomerModel::findOrFail($id);
            $customer->delete();
            Contact::findOrFail($customer->primary_contact_id)->delete();
        }

        $this->resetForm();
    }

    public function filterData()
    {
        // Custom filter logic if any
    }

    public function resetForm()
    {
        $this->customerId = null;
        $this->customer_name = '';
        $this->email_id = '';
        $this->phone = '';
        $this->company_name = '';
        $this->status = '';
        $this->primary_contact_id = null;
        $this->editMode = false;
        $this->selected = [];
        $this->selectAll = false;
    }
}
