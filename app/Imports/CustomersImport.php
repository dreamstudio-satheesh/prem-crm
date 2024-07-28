<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\MobileNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomersImport implements ToModel, WithStartRow
{
    private $mappings;
    private $mappingConfiguration;

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
        $this->mappingConfiguration = $this->getMappingConfiguration();
    }

    private function getMappingConfiguration(): array
    {
        return [
            'customer' => ['tally_serial_no', 'customer_name'],
            'address' => ['contact_person', 'address', 'email'],
            'mobile' => ['mobile_no']
        ];
    }

    public function startRow(): int
    {
        return 2; // Start processing from the second row to skip the header
    }

    public function model(array $row)
    {
        $customerData = [];
        $addressData = [];
        $mobileNumbersData = [];

        foreach ($this->mappings as $index => $attribute) {
            if (isset($row[$index]) && $attribute !== null && $row[$index] !== '') {
                // Check the mapping configuration for the attribute's table
                foreach ($this->mappingConfiguration as $table => $attributes) {
                    if (in_array($attribute, $attributes)) {
                        if ($table === 'customer') {
                            $customerData[$attribute] = $row[$index];
                        } elseif ($table === 'address') {
                            $addressData[$attribute] = $row[$index];
                        } elseif ($table === 'mobile') {
                            // Split mobile numbers by comma or semicolon and remove empty values
                            $mobileNumbers = array_filter(preg_split('/[;,]/', $row[$index]), 'strlen');
                            foreach ($mobileNumbers as $mobileNumber) {
                                $mobileNumbersData[] = $mobileNumber;
                            }
                        }
                        break;
                    }
                }
            }
        }

        if (!empty($customerData['tally_serial_no'])) {
            // Update or create customer based on a unique identifier, such as 'tally_serial_no'
            $customer = Customer::updateOrCreate(
                ['tally_serial_no' => $customerData['tally_serial_no']], // Unique identifier
                $customerData // Values to update or create with
            );

            // Handle address book if data exists
            if (!empty($addressData)) {
                $address = AddressBook::updateOrCreate(
                    ['customer_id' => $customer->customer_id], // Assuming customer_id is the foreign key
                    $addressData
                );

                // Handle mobile numbers if address is created successfully and has a valid ID
                if ($address && $address->address_id && !empty($mobileNumbersData)) {
                    foreach ($mobileNumbersData as $mobileNumber) {
                        MobileNumber::updateOrCreate(
                            ['mobile_no' => $mobileNumber], // Assuming 'mobile_no' is the unique identifier
                            ['address_id' => $address->address_id]
                        );
                    }
                }
            }

            return $customer;
        }

        // Optionally, return null or some indication of skipped row due to missing required fields
        return null;
    }
}
