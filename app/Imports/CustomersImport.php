<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomersImport implements ToModel, WithStartRow
{
    private $mappings;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    public function startRow(): int
    {
        return 2; // Start processing from the second row to skip the header
    }

    public function model(array $row)
    {
        $data = [];
        foreach ($this->mappings as $index => $attribute) {
            if (isset($row[$index]) && $attribute !== null && $row[$index] !== '') {
                $data[$attribute] = $row[$index];
            }
        }

        if (!empty($data['tally_serial_no'])) {
            // Update or create customer based on a unique identifier, such as 'tally_serial_no'
            $customer = Customer::updateOrCreate(
                ['tally_serial_no' => $data['tally_serial_no']], // Unique identifier
                $data // Values to update or create with
            );
            
            return $customer;
        }

        // Optionally, return null or some indication of skipped row due to missing required fields
        return null;
    }
}
