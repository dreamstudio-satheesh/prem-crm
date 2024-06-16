<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            ['position_name' => 'Primary Contact'],
            ['position_name' => 'MD'],
            ['position_name' => 'Auditor'],
            ['position_name' => 'Computer Services'],
            ['position_name' => 'Accountant'],
            ['position_name' => 'Staff'],
        ]);
    }
}
