<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Licence;
use App\Imports\LicencesImport;
use App\Exports\LicencesExport;
use Maatwebsite\Excel\Facades\Excel;

class LicenceMaster extends Component
{
    use WithPagination, WithFileUploads;

    public $licence_id;
    public $name, $description;
    public $search = '';
    public $upload_file;

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
        $licence = Licence::find($id);

        if ($licence) {
            $licence->delete();
            session()->flash('success', 'Licence Deleted Successfully.');
        } else {
            session()->flash('error', 'Licence Not Found.');
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

        Excel::import(new LicencesImport, $this->upload_file->getRealPath());

        session()->flash('success', 'Licences Imported Successfully.');

        // Close the modal
        $this->dispatch('close-modal');
    }

    public function export()
    {
        return Excel::download(new LicencesExport, 'licences.xlsx');
    }
}
