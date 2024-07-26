<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\ToArray;

class CustomersImport implements ToModel, WithHeadingRow, WithLimit, ToArray
{
    public function array(array $array)
    {
        dd($array); // This will dump the first few rows of your Excel file after applying the heading row
    }

    public function model(array $row)
    {
        // Model instantiation code
    }

    public function limit(): int
    {
        return 5;  // Only process the first 5 rows for testing
    }

    public function headingRow(): int
    {
        return 1;
    }
}
