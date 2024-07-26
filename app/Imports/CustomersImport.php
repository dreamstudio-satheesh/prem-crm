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
     * Maps the incoming row to an array based on the defined mappings.
     * This method is used to debug and log the CSV headers.
     *
     * @param array $row
     * @return array
     */
    public function mapping(array $row): array
    {
        // Log the headers found to debug
        Log::debug('CSV Headers Read', array_keys($row));
        return $row; // Return the row unchanged for further processing
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
