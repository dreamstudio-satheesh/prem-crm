<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::all([
            'customer_name',
            'tally_serial_no',
            'licence_editon_id',
            'primary_address_id',
            'default_customer_type_id',
            'product_id',
            'location_id',
            'staff_id',
            'amc_id',
            'amc',
            'tss_status',
            'tss_adminemail',
            'tss_expirydate',
            'profile_status',
            'remarks',
            'whatsapp_telegram_group',
            'tdl_addons',
            'auto_backup',
            'cloud_user',
            'mobile_app',
            'gst_no',
            'map_location',
            'latitude',
            'longitude',
        ]);
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Tally Serial No',
            'Licence Edition',
            'Primary Address ID',
            'Default Customer Type ID',
            'Product ID',
            'Location ID',
            'Staff ID',
            'AMC ID',
            'AMC',
            'TSS Status',
            'TSS Admin Email',
            'TSS Expiry Date',
            'Profile Status',
            'Remarks',
            'WhatsApp/Telegram Group',
            'TDL Addons',
            'Auto Backup',
            'Cloud User',
            'Mobile App',
            'GST No',
            'Map Location',
            'Latitude',
            'Longitude',
        ];
    }
}
