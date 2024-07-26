<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class PreviewImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // You can manipulate data here if needed
        return $rows;
    }
}
