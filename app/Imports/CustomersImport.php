<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    public function model(array $row)
    {
        return new Customer([
            'customer_name' => $row[0],
            'tally_serial_no' => $row[1],
            'licence_editon' => $row[2],
            'primary_address_id' => $row[3],
            'default_customer_type_id' => $row[4],
            'product_id' => $row[5],
            'location_id' => $row[6],
            'staff_id' => $row[7],
            'amc_id' => $row[8],
            'amc' => $row[9],
            'tss_status' => $row[10],
            'tss_adminemail' => $row[11],
            'tss_expirydate' => $row[12],
            'profile_status' => $row[13],
            'remarks' => $row[14],
            'whatsapp_telegram_group' => $row[15],
            'tdl_addons' => $row[16],
            'auto_backup' => $row[17],
            'cloud_user' => $row[18],
            'mobile_app' => $row[19],
            'gst_no' => $row[20],
            'map_location' => $row[21],
            'latitude' => $row[22],
            'longitude' => $row[23],
        ]);
    }
}
