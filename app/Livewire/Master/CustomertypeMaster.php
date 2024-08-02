<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerType;
use Livewire\WithFileUploads;
use App\Imports\CustomerTypesImport;
use App\Exports\CustomerTypesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class CustomerTypeMaster extends Component
{
    use WithPagination, WithFileUploads;

    public $customer_type_id;
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
        $customerTypes = CustomerType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.customer-type-master', [
            'customerTypes' => $customerTypes,
        ]);
    }

    public function resetInputFields()
    {
        $this->customer_type_id = null;
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        $this->authorizeAdmin();

        $this->validate();

        CustomerType::updateOrCreate(['id' => $this->customer_type_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetInputFields();

        $this->dispatch('show-toastr', ['message' => 'Customer Type ' . ($this->customer_type_id ? 'Updated' : 'Created') . ' Successfully.']);
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $customerType = CustomerType::findOrFail($id);
        $this->customer_type_id = $customerType->id;
        $this->name = $customerType->name;
        $this->description = $customerType->description;
    }

    public function delete($id)
    {
        $this->authorizeAdmin();

        $customerType = CustomerType::find($id);

        if ($customerType) {
            $customerType->delete();
            session()->flash('success', 'Customer Type Deleted Successfully.');
        } else {
            session()->flash('error', 'Customer Type Not Found.');
        }
        $this->dispatch('$refresh');
    }

    public function create()
    {
        $this->resetInputFields();
    }

    public function import()
    {
        $this->authorizeAdmin();

        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        Excel::import(new CustomerTypesImport, $this->upload_file->getRealPath());

        session()->flash('success', 'Customer Types Imported Successfully.');

        // Close the modal
        $this->dispatch('close-modal');
    }

    public function export()
    {
        $this->authorizeAdmin();

        return Excel::download(new CustomerTypesExport, 'customer_types.xlsx');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role != 'Admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}
