<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Location;
use Livewire\WithFileUploads;
use App\Imports\LocationsImport;
use App\Exports\LocationsExport;
use Maatwebsite\Excel\Facades\Excel;

class LocationMaster extends Component
{
    use WithPagination, WithFileUploads;

    public $location_id;
    public $name, $description;
    public $search = '';
    public $upload_file;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $locations = Location::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.location-master', [
            'locations' => $locations,
        ]);
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

        $this->dispatch('show-toastr', ['message' => 'Location ' . ($this->location_id ? 'Updated' : 'Created') . ' Successfully.']);
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
        $location = Location::find($id);

        if ($location) {
            $location->delete();
            session()->flash('success', 'Location Deleted Successfully.');
        } else {
            session()->flash('error', 'Location Not Found.');
        }
        $this->dispatch('$refresh');
    }

    public function create()
    {
        $this->resetInputFields();
    }

    public function import()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        Excel::import(new LocationsImport, $this->upload_file->getRealPath());

        session()->flash('success', 'Locations Imported Successfully.');

        $this->dispatch('close-modal');
    }

    public function export()
    {
        return Excel::download(new LocationsExport, 'locations.xlsx');
    }
}
