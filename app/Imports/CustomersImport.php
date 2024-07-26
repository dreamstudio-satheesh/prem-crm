<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;

class CustomersImport implements ToModel, WithHeadingRow
{
    private $mappings;

    public function __construct(array $mappings)
    {
        // Adjust mappings to use indices for column access
        $this->mappings = array_flip($mappings); // Flips keys with their values
    }

    public function model(array $row)
    {
        // Use column indices to map data fields
        return new Customer([
            'customer_name' => $row[$this->mappings['customer_name']] ?? null,
            'tally_serial_no' => $row[$this->mappings['tally_serial_no']] ?? null,
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Headers are expected at the first row
    }
}

