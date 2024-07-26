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
                if ($dbField === 'customer_name' && !empty($data[$dbField])) {
                    $customerNameFound = true;
                }

                // Log each mapping attempt
                Log::debug('Mapping data', [
                    'fileHeader' => $fileHeader,
                    'dbField' => $dbField,
                    'value' => $row[$fileHeader]
                ]);
            } else {
                // Log missing fileHeader cases
                Log::warning('Missing file header in CSV', [
                    'expectedHeader' => $fileHeader
                ]);
            }
        }

        if (!$customerNameFound) {
            Log::warning('Skipped row due to missing or empty customer_name', ['row' => $row]);
            return null; // Skip this row
        }

        Log::info('Processing row', ['data' => $data]);

        $customer = new Customer($data);
        $customer->save();

        Log::info('Successfully imported customer', ['customer_id' => $customer->id]);

        return $customer;
    }
}
