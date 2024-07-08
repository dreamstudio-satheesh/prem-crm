<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NatureOfIssue;

class NatureOfIssueSeeder extends Seeder
{
    public function run()
    {
        $issues = [
            "SU", "MU", "TSS SU", "MU SU", "Customization", "Onsite", "AMC- Multi User", "AMC- Single User",
            "Bank Doubts", "Cheque Print", "Crack Version", "Data Issue", "Data Migration", "Data Restore",
            "Data Splitting", "Data Synchronization", "Email Configuration", "E-Way Bill Doubts",
            "Excel to Tally Import", "Excel to Tally Import Doubts", "Mobile App", "Free Addons", "GST 3B Doubts",
            "GST CALCULATION ISSUE", "GST Doubts", "GST Filing Doubts", "GST Mismatch", "GSTR 1 Doubts",
            "GSTR 2A", "GST Portal Filing Doubts", "HSN Code Issue", "INTEREST CALCULATION ISSUE", "Invoice Isssue",
            // Add all other unique issues here
            // Make sure to check the list for any duplicates or typos to ensure uniqueness
        ];

        foreach ($issues as $issue) {
            NatureOfIssue::firstOrCreate(['name' => $issue]);
        }
    }
}
