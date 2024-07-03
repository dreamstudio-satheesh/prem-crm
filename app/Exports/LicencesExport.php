<?php

namespace App\Exports;

use App\Models\Licence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicencesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Licence::select('id', 'name', 'description')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
           'id',
            'name',
            'description',
        ];
    }
}
