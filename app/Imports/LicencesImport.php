<?php

namespace App\Imports;

use App\Models\Licence;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LicencesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return Licence::updateOrCreate(
            ['id' => $row['id']],
            [
                'name' => $row['name'],
                'description' => $row['description'],
            ]
        );
    }
}
