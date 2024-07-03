<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;

class LocationsImport implements ToModel
{
    public function model(array $row)
    {
        return new Location(
            ['id' => $row['id']], 
            [
                'name' => $row['name'],
                'description' => $row['description'],
            ]
        );
    }
}
