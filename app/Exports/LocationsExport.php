<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LocationsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Location::select('id', 'name', 'description')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
        ];
    }
}
