<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Industry;

class IndustryMaster extends Component
{
    use WithPagination;

    public $product_id;
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

        return view('livewire.industry-master', compact('industry'));
    }

    public function resetInputFields()
    {
        $this->product_id = null;
        $this->name = ''; 
    }

    public function store()
    {
        $this->validate();

        Product::updateOrCreate(['id' => $this->product_id], [
            'name' => $this->name,
            'description' => $this->description, 
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Product '.($this->industry_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        
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
