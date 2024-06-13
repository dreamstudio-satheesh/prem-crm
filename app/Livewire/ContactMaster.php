<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactMaster extends Component
{
    use WithPagination;

    public $contact_id;
    public $name, $phone, $email, $address, $company, $notes, $user_id;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:contacts,phone',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'user_id' => 'nullable|exists:users,id',
    ];

    public function render()
    {
        $contacts = Contact::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('phone', 'like', '%'.$this->search.'%')
            ->orderBy('contact_id', 'desc')
            ->paginate(10);

        return view('livewire.contact-master', compact('contacts'));
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
        $this->user_id = null;
    }

    public function store()
    {
        $this->validate();

        Contact::updateOrCreate(['contact_id' => $this->contact_id], [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'company' => $this->company,
            'notes' => $this->notes,
            'user_id' => $this->user_id,
        ]);

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
        $this->user_id = $contact->user_id;
    }

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
        $this->dispatch('show-toastr', ['message' => 'Contact Deleted Successfully.']);
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
