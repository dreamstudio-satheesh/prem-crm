<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Licence;
use App\Imports\CustomersImport;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CustomerList extends Component
{
    use WithPagination, WithFileUploads;

    public $upload_file;
    public $search = '';
    public $status = '';
    public $tss_status = '';
    public $amc = '';
    public $license_edition = '';
    public $product = '';
    public $auto_backup = '';
    public $cloud_user = '';
    public $mobile_app = '';
    public $whatsapp = '';
    public $start_date;
    public $end_date;
    public $products = [];
    public $license_editions = [];
    public $showFilters = false;


    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->products = Product::all();
        $this->license_editions = Licence::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::withCount('AddressBooks')
            ->when($this->search, function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->tss_status, function ($query) {
                $query->where('tss_status', $this->tss_status);
            })
            ->when($this->amc, function ($query) {
                $query->where('amc', $this->amc);
            })
            ->when($this->license_edition, function ($query) {
                $query->where('license_edition', $this->license_edition);
            })
            ->when($this->product, function ($query) {
                $query->where('product', $this->product);
            })
            ->when($this->auto_backup, function ($query) {
                $query->where('auto_backup', $this->auto_backup);
            })
            ->when($this->cloud_user, function ($query) {
                $query->where('cloud_user', $this->cloud_user);
            })
            ->when($this->mobile_app, function ($query) {
                $query->where('mobile_app', $this->mobile_app);
            })
            ->when($this->whatsapp, function ($query) {
                $query->where('whatsapp', $this->whatsapp);
            })
            ->when($this->start_date, function ($query) {
                $query->whereDate('created_at', '>=', Carbon::parse($this->start_date));
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('created_at', '<=', Carbon::parse($this->end_date));
            })
            ->paginate(10);

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

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
}
