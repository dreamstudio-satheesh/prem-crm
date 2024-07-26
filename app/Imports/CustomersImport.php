<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    protected $mappings;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;

        // Debugging: Uncomment to check mappings
        // dd($this->mappings);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $data = [];

        foreach ($this->mappings as $dbField => $header) {
            if (!is_null($header) && isset($row[$header])) {
                $data[$dbField] = $row[$header];

                dd( $data[$dbField]);
            }
        }

        // Ensure required fields are present
        if (empty($data['customer_name'])) {
            // Handle missing required field
            return null; // Skip this row or handle it differently
        }

        return new Customer($data);
    }
}
