<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Addresstype;
use DB;

class AddresstypeMaster extends Component
{
    use WithPagination;

    public $addresstype_id;
    public $name, $description;
    public $search = '';
    public $primary_id, $secondary_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'primary_id' => 'required|integer',
        'secondary_id' => 'required|integer',
    ];

    public function mount()
    {
        $primaryCategory = DB::table('addresstypeprimary')->first();
        if ($primaryCategory) {
            $this->primary_id = $primaryCategory->primaryid;
            $this->secondary_id = $primaryCategory->secondaryid;
        }
    }

    public function updatedPrimaryId()
    {
        $this->updatePrimaryCategory();
    }

    public function updatedSecondaryId()
    {
        $this->updatePrimaryCategory();
    }

    public function updatePrimaryCategory()
    {
        DB::table('addresstypeprimary')->where('id', 1)->update([
            'primaryid' => $this->primary_id,
            'secondaryid' => $this->secondary_id,
        ]);

        $this->dispatch('show-toastr', ['message' => 'Categories Updated Successfully.']);
    }

    public function render()
    {
        $addresstypes = Addresstype::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $addresstypeList = DB::table('addresstype')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.addresstype-master', compact('addresstypes', 'addresstypeList'));
    }

    public function resetInputFields()
    {
        $this->addresstype_id = null;
        $this->name = '';
        $this->description = '';
        $this->primary_id = null;
        $this->secondary_id = null;
    }

    public function store()
    {
        $this->validate();

        Addresstype::updateOrCreate(['id' => $this->addresstype_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Address Type ' . ($this->addresstype_id ? 'Updated' : 'Created') . ' Successfully.']);
    }

    public function edit($id)
    {
        $addresstype = Addresstype::findOrFail($id);
        $this->addresstype_id = $addresstype->id;
        $this->name = $addresstype->name;
        $this->description = $addresstype->description;
    }

    public function delete($id)
    {
        Addresstype::findOrFail($id)->delete();
        session()->flash('success', 'Address Type Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
