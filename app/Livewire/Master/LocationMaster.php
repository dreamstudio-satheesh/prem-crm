<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Location;

class LocationMaster extends Component
{
    use WithPagination;

    public $location_id;
    public $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $locations = Location::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.location-master', compact('locations'));
    }

    public function resetInputFields()
    {
        $this->location_id = null;
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate();

        Location::updateOrCreate(['id' => $this->location_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Location '.($this->location_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $this->location_id = $location->id;
        $this->name = $location->name;
        $this->description = $location->description;
    }

    public function delete($id)
    {
        Location::findOrFail($id)->delete();
        session()->flash('success', 'Location Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
