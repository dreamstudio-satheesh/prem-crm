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

        // Iterate over the mappings and set the appropriate fields in $data
        foreach ($this->mappings as $fileHeader => $dbField) {
            if (isset($row[$fileHeader])) {
                $data[$dbField] = $row[$fileHeader];
            }
        }

        // Check if the mandatory fields are set
        if (empty($data['customer_name'])) {
            Log::warning('Skipped row due to missing customer_name', [$this->mappings]);
            return null; // Skip this row
        }

        return new Customer($data);
    }
}
