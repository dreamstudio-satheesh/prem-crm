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

        // dd($this->mappings); // Remove the dd statement now that you have verified the mappings
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
            }
        }

        return new Customer($data);
    }
}
