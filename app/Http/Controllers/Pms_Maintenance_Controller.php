<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class Pms_Maintenance_Controller extends Controller
{



    public function pms_function()
    {




        // $nextYearStart = $currentDate->copy()->addYear()->startOfYear();

        // if ($lastMaintenanceDate->lt($nextYearStart)) {
        //     echo "Maintenance is due for next year. Proceeding to next year.\n";
        //     // Proceed to next year
        // } else {
        //     echo "Maintenance for next year is not due yet.\n";
        //     // Alert: Maintenance not due
        // }



        // $nextMonthStart = $currentDate->copy()->addMonthNoOverflow()->startOfMonth();

        // if ($lastMaintenanceDate->lt($nextMonthStart)) {
        //     echo "Maintenance is due for next month. Proceeding to next month.\n";
        //     // Proceed to next month
        // } else {
        //     echo "Maintenance for next month is not due yet.\n";
        //     // Alert: Maintenance not due
        // }




        // $lastMaintenanceDate = Carbon::parse('2025-06-03');
        // $currentDate = Carbon::now();

        // $quarters = [
        //     1 => '01-01',
        //     2 => '04-01',
        //     3 => '07-01',
        //     4 => '10-01'
        // ];

        // $currentQuarter = ceil($currentDate->month / 3);
        // $nextQuarter = $currentQuarter % 4 + 1;
        // $nextQuarterStart = Carbon::createFromFormat('Y-m-d', $currentDate->year . '-' . $quarters[$nextQuarter]);

        // if ($lastMaintenanceDate->lt($nextQuarterStart)) {
        //     echo "Maintenance is due for Q{$nextQuarter}. Proceeding to Q{$nextQuarter}.\n";
        //     // Proceed to Q{$nextQuarter}
        // } else {
        //     echo "Maintenance for Q{$nextQuarter} is not due yet.\n";
        //     // Alert: Maintenance not due
        // }



        // $nextMaintenanceDate = $lastMaintenanceDate->copy()->addMonths(6);

        // if ($currentDate->lt($nextMaintenanceDate)) {
        //     echo "Maintenance is due in 6 months. Proceeding to next maintenance.\n";
        //     // Proceed to next maintenance
        // } else {
        //     echo "Maintenance in 6 months is not due yet.\n";
        //     // Alert: Maintenance not due
        // }








    }

    public function pms_page()
    {
        return view('pms_page.pms_sample');
    }
}
