<?php

namespace App\Imports;

use App\Models\CustomerType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerTypesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return CustomerType::updateOrCreate(
            ['id' => $row['id']],
            [
                'name' => $row['name'],
                'description' => $row['description'],
            ]
        );
    }
}
