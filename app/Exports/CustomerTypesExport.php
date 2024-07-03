<?php

namespace App\Exports;

use App\Models\CustomerType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerTypesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CustomerType::select('id', 'name', 'description')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
        ];
    }

    
}
