<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Addresstype;

class AddresstypeMaster extends Component
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
        $addresstype = Addresstype::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.addresstype-master', compact('addresstype'));
    }

    public function resetInputFields()
    {
        $this->addresstype_id = null;
        $this->name = '';
        $this->description = '';     
        
    }

    public function store()
    {
        $this->validate();

        Addresstype::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'description' => $this->description,            
             
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Address Type '.($this->addresstype_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $addresstype = Addresstype::findOrFail($id);
        $this->id = $addresstype->id;
        $this->name = $addresstype->name;
        $this->description = $addresstype->description;
     
    }

    public function delete($id)
    {
      //  Addresstype::findOrFail($id)->delete();
        session()->flash('success', 'Address Type Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
