<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PreviewImport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class CustomerImportController extends Controller
{
    public $headers = [];
    public $selectedMappings = [];
    public $columnOptions = [
        'customer_name' => 'Customer Name',
        'tally_serial_no' => 'Tally Serial No',
        'contact_person' => 'Contact Person',
        'mobile_no' => 'Mobile No',
        'email' => 'EMail',
        'address' => 'Address',
        'amc_from_date' => 'AMC From Date',
        'amc_to_date' => 'AMC To Date',
        'amc_renewal_date' => 'AMC Renewal Date',
        'amc_last_year_amount' => 'AMC Last Year Amount',
        'amc_amount' => 'AMC Amount',
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

        // Generate numeric headers for indexing
        $headers = range(0, count($rawHeaders) - 1);

        // Remove the header row from the preview data
        unset($previewData[0]);
        return view('customer_import_preview', [
            'headers' => $headers,
            'rawHeaders' => $rawHeaders,
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

            // Delete the temp file after import
            Storage::disk('public')->delete($tempFilePath);

            return redirect()->route('customers.index')->with('success', 'Customers imported successfully.');
        } catch (\Exception $e) {
            // Optionally delete the file even on failure if you don't need to retry the import
            Storage::disk('public')->delete($tempFilePath);

            return $e->getMessage();

           // return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
