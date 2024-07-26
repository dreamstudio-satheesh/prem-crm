<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel, WithStartRow
{
    private $mappings;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    public function startRow(): int
    {
        return 2; // Assuming you want to skip the header
    }

    public function model(array $row)
    {
        $data = [];
        foreach ($this->mappings as $index => $attribute) {
            if (isset($row[$index]) && $attribute ) {
                $data[$attribute] = $row[$index];
            }
        }

        $customer = new Customer($data);

        if ($customer->save()) {
            Log::info('Successfully imported customer', ['customer_id' => $customer->customer_id]);
        } else {
            Log::error('Failed to save customer', ['data' => $customer->attributesToArray()]);
        }

        return $customer;
    }
}
