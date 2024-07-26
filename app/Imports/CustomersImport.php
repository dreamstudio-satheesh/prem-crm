<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;

class CustomersImport implements ToModel, WithHeadingRow
{
    private $mappings;

    public function __construct($mappings)
    {
        $this->mappings = $mappings;
    }

    public function model(array $row)
    {
        $customerData = [];
        
        foreach ($this->mappings as $dbField => $header) {
            $customerData[$dbField] = $row[$header] ?? null;
        }

        dd($customerData); // Debugging: dump the customer data to inspect it

        return new Customer($customerData);
    }

    public function headingRow(): int
    {
        return 1; // Assuming the first row is the header
    }
}
