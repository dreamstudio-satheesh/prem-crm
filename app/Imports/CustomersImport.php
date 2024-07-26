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

        // Dump and die to see the mappings array
        dd($this->mappings);
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
            if (isset($row[$header])) {
                $data[$dbField] = $row[$header];
            }
        }

        return new Customer($data);
    }
}
