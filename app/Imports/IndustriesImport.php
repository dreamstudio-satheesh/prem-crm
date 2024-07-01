<?php

namespace App\Imports;

use App\Models\Industry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndustriesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Industry::updateOrCreate(
            ['id' => $row['id']], // Assuming 'id' is the primary key
            [
                'name' => $row['name'],
                'description' => $row['description'],
            ]
        );
    }
}

