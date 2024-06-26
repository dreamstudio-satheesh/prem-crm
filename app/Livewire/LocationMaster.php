<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;

class LocationMaster extends Component
{
    public $locations;
    public $name;
    public $location_id;

    public function mount()
    {
        $this->locations = Location::all();
    }

    public function addLocation()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Location::create(['name' => $this->name]);
        $this->name = '';
        $this->locations = Location::all();
        session()->flash('message', 'Location added successfully.');
    }

    public function removeLocation($locationId)
    {
        Location::find($locationId)->delete();
        $this->locations = Location::all();
        session()->flash('message', 'Location removed successfully.');
    }

    public function render()
    {
        return view('livewire.location-component');
    }
}
