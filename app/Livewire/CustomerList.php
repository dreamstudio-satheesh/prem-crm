<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Licence;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Imports\PreviewImport;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerList extends Component
{
    use WithPagination, WithFileUploads;

    public $headers = [];
    public $mappings = [];
    public $columnOptions = [
        'customer_name' => 'Customer Name',
        'tally_serial_no' => 'Tally Serial No',
        // Add more options based on your database schema
    ];
    public $previewData;
    public $tempFilePath;


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
            ->when(strlen($this->search) > 2, function ($query) {
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
            ->paginate(10);

        return view('livewire.customer-list', ['customers' => $customers]);
    }



    public function import()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        // Store the file temporarily
        $path = $this->upload_file->store('temp', 'public');

        // Save the path to a component property to use later
        $this->tempFilePath = $path;

        // Load preview data
        $this->previewData = Excel::toArray(new PreviewImport, storage_path('app/public/' . $path))[0];

        session()->flash('success', 'Customers Imported Successfully.');

        // Close the modal
        // $this->dispatch('close-modal');
    }

    public function uploadAndPrepareImport()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);
    
        $path = $this->upload_file->store('temp', 'public');
        $this->tempFilePath = $path;
        $array = Excel::toArray(new PreviewImport, storage_path('app/public/' . $path));
    
        $this->previewData = $array[0];
        $this->headers = $this->previewData[0];

        dd( $this->headers);

        
    }
    

    public function confirmImport()
    {

        dd($this->mappings);
        try {
            $import = new CustomersImport($this->mappings);
            Excel::import($import, storage_path('app/public/' . $this->tempFilePath));
            session()->flash('success', 'Customers Imported Successfully.');
            $this->resetPreview();
        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function resetPreview()
    {
        // Reset all properties to their initial state
        $this->previewData = null; // Reset the preview data
        $this->headers = [];       // Reset the headers array
        $this->mappings = [];      // Reset the mappings array
        $this->tempFilePath = null; // Clear the path to the temporary file

        // If using file uploads with Livewire, reset the file upload input
        $this->reset('upload_file');

        // Optionally clear any session messages
        session()->forget(['success', 'error']);

        // Dispatch an event to close the modal if you're handling modals via JavaScript
        $this->dispatch('close-modal');
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
}
