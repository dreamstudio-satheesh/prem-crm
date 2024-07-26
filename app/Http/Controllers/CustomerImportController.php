<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PreviewImport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerImportController extends Controller
{
    public $headers = [];
    public $selectedMappings = [];
    public $columnOptions = [
        'customer_name' => 'Customer Name',
        'tally_serial_no' => 'Tally Serial No',
        // Add more options based on your database schema
    ];

    public function showImportForm()
    {
        return view('customer_import');
    }

    public function uploadAndPrepareImport(Request $request)
    {
        $request->validate([
            'upload_file' => 'required|mimes:xlsx,csv,txt',
        ]);

        $path = $request->file('upload_file')->store('temp', 'public');
        $array = Excel::toArray(new PreviewImport, storage_path('app/public/' . $path));
        $previewData = array_slice($array[0], 0, 4); // Limit preview to 3 rows, including headers
        $rawHeaders = $previewData[0]; // Directly use the first row as headers

        // Filter out null or empty headers and ensure headers are strings
        $headers = array_filter(array_map('trim', $rawHeaders), function ($header) {
            return !is_null($header) && $header !== '';
        });

        // Remove the header row from the preview data
        unset($previewData[0]);

        return view('customer_import_preview', [
            'headers' => $headers,
            'previewData' => $previewData,
            'columnOptions' => $this->columnOptions,
            'tempFilePath' => $path,
        ]);
    }

    public function importData(Request $request)
    {
        $mappings = $request->input('mappings', []);
        $tempFilePath = $request->input('tempFilePath');

        try {
            $import = new CustomersImport($mappings);
            Excel::import($import, storage_path('app/public/' . $tempFilePath));
            return redirect()->route('customers.index')->with('success', 'Customers imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
