<?php

namespace App\Exports;

use App\Models\Industry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndustriesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Industry::select('id', 'name', 'description')->get();
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

