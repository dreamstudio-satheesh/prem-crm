<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    /**
     * Maps the incoming row to a model instance.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if the essential data is present
        if (empty($row[1])) {
            Log::warning('Skipped row due to missing customer name', ['row' => $row]);
            return null; // Skip this row if customer name is missing
        }

        $customer = new Customer([
            'customer_name'    => $row[1], // assuming the customer name is in the second column
            'tally_serial_no'  => $row[5] ?? null, // assuming the tally serial number is in the sixth column, use null if not present
        ]);

        $customer->save(); // Save the customer
        Log::info('Successfully imported customer', ['customer_id' => $customer->customer_id]);

        return $customer;
    }
}
