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

    // Ensure any assignments to selectedMappings are correct
    public function setSelectedMapping($header, $field)
    {
        if (is_string($header) && is_string($field)) {
            $this->selectedMappings[$header] = $field; // Ensure values are strings
        } else {
            logger()->error('Invalid mapping assignment:', ['header' => $header, 'field' => $field]);
        }
    }

    public function updatedSelectedMappings()
    {
        $this->mappings = [];

        // Add debugging to see the current state of selectedMappings
        logger()->info('Selected Mappings Before Processing:', $this->selectedMappings);

        foreach ($this->selectedMappings as $header => $dbField) {
            // Temporary check to catch non-string values
            if (is_array($dbField)) {
                logger()->error('Non-string value found in selectedMappings:', ['header' => $header, 'dbField' => $dbField]);
                continue; // Skip this invalid mapping
            }

            // Ensure dbField is a string
            if (!empty($dbField) && is_string($header) && is_string($dbField)) {
                $this->mappings[$dbField] = $header; // Maps database field to header
            }
        }

        // Log the final mappings array
        logger()->info('Mappings:', $this->mappings);
    }

    public function uploadAndPrepareImport()
    {
        $this->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        $path = $this->upload_file->store('temp', 'public');
        $this->tempFilePath = $path;
        $array = Excel::toArray(new PreviewImport, storage_path('app/public/' . $path));

        $this->previewData = array_slice($array[0], 0, 4); // Limit preview to 3 rows, including headers
        $rawHeaders = $this->previewData[0]; // Directly use the first row as headers

        // Filter out null or empty headers and ensure headers are strings
        $this->headers = array_filter(array_map('trim', $rawHeaders), function ($header) {
            return !is_null($header) && $header !== '';
        });

        // Remove the header row from the preview data
        unset($this->previewData[0]);

        // Debugging
        logger()->info('Headers:', $this->headers);
        logger()->info('Preview Data:', $this->previewData);
    }




    public function importData()
    {
        dd($this->mappings);

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
