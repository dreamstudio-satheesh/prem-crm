<?php

namespace App\Exports;

use App\Models\CustomerType;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerTypesExport implements FromCollection
{
    public function collection()
    {
        return CustomerType::all();
    }
}
