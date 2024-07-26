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
        $this->mappings = $mappings;
    }

    public function model(array $row)
    {
        return new Customer([
            'customer_name' => $row[$this->mappings['customer_name']] ?? null,
            'tally_serial_no' => $row[$this->mappings['tally_serial_no']] ?? null,
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Ensure the first row is treated as the header row
    }
}

