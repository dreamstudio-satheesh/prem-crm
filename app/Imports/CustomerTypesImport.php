<?php

namespace App\Imports;

use App\Models\CustomerType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerTypesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            CustomerType::updateOrCreate(
                ['id' => $row['id']], 
                [
                    'name' => $row['name'], 
                    'description' => $row['description'], 
                ]
            );
        }
    }
}
