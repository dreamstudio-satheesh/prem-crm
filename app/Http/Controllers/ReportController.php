<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    

    public function getHourlyProductionReport()
    {
        $start = Carbon::today()->setTime(9, 0)->toDateTimeString();
        $end = Carbon::today()->setTime(21, 0)->toDateTimeString();
    
        // Get the hourly production report
        $report = DB::table('trackings')
            ->select(DB::raw('checkpoint_id, HOUR(timestamp) as hour, COUNT(*) as production_count'))
            ->whereBetween('timestamp', [$start, $end])
            ->groupBy('checkpoint_id', 'hour')
            ->orderBy('checkpoint_id')
            ->orderBy('hour')
            ->get();
    
        // Get all checkpoints grouped by line_id
        $checkpoints = DB::table('checkpoints')
            ->select('id', 'section', 'line_id', 'checkpoint_no')
            ->orderBy('line_id')
            ->get()
            ->groupBy('line_id');
    
        // Create an array of hours for the table headers
        $hours = range(9, 21);
    
        // Merge checkpoints with report data and pivot the report
        $mergedReport = $checkpoints->map(function($lineCheckpoints) use ($report, $hours) {
            return $lineCheckpoints->map(function($checkpoint) use ($report, $hours) {
                $checkpoint->hourly_report = array_fill_keys($hours, 0); // Initialize all hours with 0
                foreach ($report as $data) {
                    if ($data->checkpoint_id == $checkpoint->id) {
                        $hour = (int)$data->hour;
                        if ($hour >= 9 && $hour <= 21) {
                            $checkpoint->hourly_report[$hour] = $data->production_count;
                        }
                    }
                }
                return $checkpoint;
            });
        });
    
        return view('reports.hourly', ['report' => $mergedReport, 'hours' => $hours]);
    }

}
