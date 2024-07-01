<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Industry;
use Livewire\WithFileUploads;
use App\Imports\IndustriesImport;
use App\Exports\IndustriesExport;
use Maatwebsite\Excel\Facades\Excel;

class IndustryMaster extends Component
{
    use WithPagination, WithFileUploads;

    public $industry_id;
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
        $industries = Industry::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.industry-master', [
            'industries' => $industries,
        ]);
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

        $this->dispatch('show-toastr', ['message' => 'Industry ' . ($this->industry_id ? 'Updated' : 'Created') . ' Successfully.']);
        
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
        $industry = Industry::find($id);

        if ($industry) {
            $industry->delete();
            session()->flash('success', 'Industry Deleted Successfully.');
        } else {
            session()->flash('error', 'Industry Not Found.');
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

        Excel::import(new IndustriesImport, $this->upload_file->getRealPath());

        session()->flash('success', 'Industries Imported Successfully.');

        // Close the modal
        $this->dispatch('close-modal');
    }

    public function export()
    {
        return Excel::download(new IndustriesExport, 'industries.xlsx');
    }
}
