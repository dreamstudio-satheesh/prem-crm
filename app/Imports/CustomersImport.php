<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersImport implements ToModel, WithHeadingRow, WithMapping
{
    protected $mappings;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * This method will be used to log and pass through the data.
     * It must return an array that will be passed to the model() method.
     *
     * @param array $row
     * @return array
     */
    public function map($row): array
    {
        // Log the row data to see what is being processed
        Log::debug('Processing row with mapping', $row);

        // Pass through the row unchanged
        return $row;
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
            }
        }

        if (!$customerNameFound) {
            Log::warning('Skipped row due to missing or empty customer_name', ['row' => $row]);
            return null; // Skip this row
        }

        $customer = new Customer($data);
        $customer->save();
        Log::info('Successfully imported customer', ['customer_id' => $customer->id]);

        return $customer;
    }
}
