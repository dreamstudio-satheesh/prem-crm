<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    protected $mappings;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * Maps the incoming row to a model instance based on defined mappings.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $data = [];
        $customerNameFound = false;

        // Iterate over the mappings and set the appropriate fields in $data
        foreach ($this->mappings as $fileHeader => $dbField) {
            if (isset($row[$fileHeader])) {
                $data[$dbField] = $row[$fileHeader];

                // Check for customer_name directly in the loop
                if ($dbField === 'customer_name' && !empty($data[$dbField])) {
                    $customerNameFound = true;
                }
            }
        }


         // Proceed if the customer name is found and valid
         Log::info('Processing row', ['data' => $data]);

         
        // Log if the customer name is still missing despite checking within the loop
        if (!$customerNameFound) {
            Log::warning('Skipped row due to missing or empty customer_name', ['row' => $row]);
            return null; // Skip this row
        }

       

        $customer = new Customer($data);
        $customer->save();

        // Optionally, log after successfully saving the record
        Log::info('Successfully imported customer', ['customer_id' => $customer->id]);

        return $customer;
    }
}
