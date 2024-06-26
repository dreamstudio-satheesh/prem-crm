<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Industry;

class IndustryMaster extends Component
{
    use WithPagination;

    public $industry_id;
    public $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
     
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',        
    ];

    public function render()
    {
        $industry = Industry::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.industry-master', compact('industry'));
    }

    public function resetInputFields()
    {
        $this->industry_id = null;
        $this->name = ''; 
    }

    public function store()
    {
        $this->validate();

        Industry::updateOrCreate(['id' => $this->industry_id], [
            'name' => $this->name,
            'description' => $this->description, 
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Industry '.($this->industry_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $industry = Industry::findOrFail($id);
        $this->industry_id = $industry->id;
        $this->name = $industry->name;
        $this->description = $industry->description;
        
    }

    public function delete($id)
    {
        Industry::findOrFail($id)->delete();
        session()->flash('success', 'Industry Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
