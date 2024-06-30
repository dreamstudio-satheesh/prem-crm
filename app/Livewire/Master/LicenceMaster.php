<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Licence;

class LicenceMaster extends Component
{
    use WithPagination;

    public $licence_id;
    public $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $licences = Licence::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.licence-master', compact('licences'));
    }

    public function resetInputFields()
    {
        $this->licence_id = null;
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate();

        Licence::updateOrCreate(['id' => $this->licence_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Licence '.($this->licence_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $licence = Licence::findOrFail($id);
        $this->licence_id = $licence->id;
        $this->name = $licence->name;
        $this->description = $licence->description;
    }

    public function delete($id)
    {
        Licence::findOrFail($id)->delete();
        session()->flash('success', 'Licence Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
