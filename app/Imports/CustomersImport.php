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

        foreach ($this->mappings as $index => $dbField) {
            if (isset($row[$index]) && !is_null($dbField)) {
                $data[$dbField] = $row[$index];
            }
        }

       

        return new Customer($data);
    }
}
