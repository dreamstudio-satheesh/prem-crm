<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;

class LocationsImport implements ToModel
{
    public function model(array $row)
    {
        return new Location([
            'name' => $row[0],
            'description' => $row[1],
        ]);
    }
}
