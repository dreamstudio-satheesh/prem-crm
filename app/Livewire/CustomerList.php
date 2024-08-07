<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Licence;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerList extends Component
{
    use WithPagination;


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
        $customers = Customer::withCount('AddressBooks','primaryMobileNumber')
            ->when(strlen($this->search) > 2, function ($query) {
                $query->where('customer_name', 'like', '%' . $this->search . '%')
                ->orWhere('tally_serial_no', 'like', '%' . $this->search . '%');
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
                $query->where('licence_editon_id', $this->license_edition);
            })
            ->when($this->product, function ($query) {
                $query->where('product_id', $this->product);
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
            ->paginate(25);

        return view('livewire.customer-list', ['customers' => $customers]);
    }



    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;

        $this->dispatch('filterToggled');
    }

    public function deleteCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->delete();
        
        session()->flash('message', 'Customer deleted successfully.');

        // Optionally, reset the page to the first page if the current page is empty after deletion
        $this->resetPage();
    }
}
