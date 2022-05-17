<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class Sales implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        $total = 0;
        $total1 = 0;
        for ($month = 1; $month <= 31; $month++) {
            if($total <= 825){
                $rand = rand(19, 35);
            }else{
                $rand = 0;
            }
            if($total1 <= 475){
                $malt = rand(14,19);
            }else{
                $malt = 0;
            }

            $total = $total + $rand;
            $sheets[] = new SalesPerDayExport($month,$rand,$malt);
        }

        return $sheets;
    }
}
