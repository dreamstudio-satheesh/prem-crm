<?php

namespace Database\Seeders;

use App\Models\Checkpoint;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkpoints = array(
            array('id' => '1','section' => 'cutting','line_id' => '1','checkpoint_no' => '1','created_at' => '2024-05-24 22:51:20','updated_at' => '2024-05-24 22:51:20'),
            array('id' => '2','section' => 'sewing','line_id' => '1','checkpoint_no' => '2','created_at' => '2024-05-24 22:51:25','updated_at' => '2024-05-24 22:51:25'),
            array('id' => '3','section' => 'sewing','line_id' => '1','checkpoint_no' => '3','created_at' => '2024-05-24 22:51:43','updated_at' => '2024-05-24 22:51:43'),
            array('id' => '4','section' => 'sewing','line_id' => '1','checkpoint_no' => '4','created_at' => '2024-05-24 22:51:53','updated_at' => '2024-05-24 22:51:53'),
            array('id' => '5','section' => 'cutting','line_id' => '2','checkpoint_no' => '1','created_at' => '2024-05-24 22:53:25','updated_at' => '2024-05-24 22:53:25'),
            array('id' => '6','section' => 'sewing','line_id' => '2','checkpoint_no' => '2','created_at' => '2024-05-24 22:53:35','updated_at' => '2024-05-24 22:53:35'),
            array('id' => '7','section' => 'sewing','line_id' => '2','checkpoint_no' => '3','created_at' => '2024-05-24 22:53:45','updated_at' => '2024-05-24 22:53:45'),
            array('id' => '8','section' => 'sewing','line_id' => '2','checkpoint_no' => '4','created_at' => '2024-05-24 22:53:54','updated_at' => '2024-05-24 22:53:54')
          );

          Checkpoint::insert($checkpoints);

    }
}
