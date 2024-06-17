<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customertype;

class CustomertypeMaster extends Component
{
    use WithPagination;

    public $id;
    public $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
     
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',        
    ];

    public function render()
    {
        $customertype = Customertype::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.customertype-master', compact('customertype'));
    }

    public function resetInputFields()
    {
        $this->id = null;
        $this->name = '';
        $this->description = ''; 
    }

    public function store()
    {
        $this->validate();

        Customertype::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'description' => $this->description,           
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Customer Type '.($this->id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $customertype = Customertype::findOrFail($id);
        $this->id = $customertype->id;
        $this->name = $customertype->name;
        $this->description = $customertype->description;
         
    }

    public function delete($id)
    {
        //Customertype::findOrFail($id)->delete();
        session()->flash('success', 'Customer Type Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
