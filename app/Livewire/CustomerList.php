<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Imports\CustomersImport;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerList extends Component
{
    use WithPagination, WithFileUploads;

    public $upload_file;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $customers = Customer::withCount('AddressBooks')->paginate(10);
        return view('livewire.customer-list', ['customers' => $customers]);
    }

    public function import()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        Excel::import(new CustomersImport, $this->upload_file->getRealPath());

        session()->flash('success', 'Customers Imported Successfully.');

        // Close the modal
        $this->dispatch('close-modal');
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }
}
