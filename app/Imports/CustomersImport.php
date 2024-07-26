<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Customer;

class CustomersImport implements ToModel
{
    private $mappings;

    public function __construct($mappings)
    {
        $this->mappings = $mappings;
    }

    public function model(array $row)
    {
        return new Customer([
            'customer_name' => $row[$this->mappings['customer_name']],
            'tally_serial_no' => $row[$this->mappings['tally_serial_no']],
            // Map other fields accordingly
        ]);
    }
}
