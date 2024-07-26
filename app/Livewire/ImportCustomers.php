<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\PreviewImport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportCustomers extends Component
{
    use WithFileUploads;

    public $upload_file;
    public $previewData;
    public $headers = [];
    public $selectedMappings = [];
    public $mappings = [];
    public $tempFilePath;

    public $columnOptions = [
        'customer_name' => 'Customer Name',
        'tally_serial_no' => 'Tally Serial No',
        // Add more options based on your database schema
    ];

    public function uploadAndPrepareImport()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        $path = $this->upload_file->store('temp', 'public');
        $this->tempFilePath = $path;
        $array = Excel::toArray(new PreviewImport, storage_path('app/public/' . $path));

        $this->previewData = $array[0];
        $this->headers = array_keys($this->previewData[0]);  // Corrected to use array_keys
    }

    public function setUserMappings()
    {
        $this->mappings = [];
        foreach ($this->selectedMappings as $header => $dbField) {
            if (!empty($dbField)) {
                $this->mappings[$dbField] = $header; // Maps database field to header
            }
        }

        // Optionally, log or dump to check if mappings are set correctly
        logger()->info('User defined mappings:', $this->mappings);
    }

    public function importData()
    {
        try {
            $import = new CustomersImport($this->mappings);
            Excel::import($import, storage_path('app/public/' . $this->tempFilePath));
            session()->flash('success', 'Customers imported successfully.');
            $this->resetPreview();
        } catch (\Exception $e) {
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function resetPreview()
    {
        $this->upload_file = null;
        $this->previewData = null;
        $this->headers = [];
        $this->selectedMappings = [];
        $this->mappings = [];
        $this->tempFilePath = null;
    }

    public function render()
    {
        return view('livewire.import-customers');
    }
}

