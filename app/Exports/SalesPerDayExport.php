<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesPerDayExport implements FromCollection,WithTitle,WithHeadings
{
    private $day;
    private $rand;
    private $malt;
    public function __construct(int $day,$rand,$malt)
    {
        $this->day  = $day;
        $this->rand  = $rand;
        $this->malt  = $malt;
    }
    public function collection()
    {
        $products = [
            '4TH STREET 750ML RED',
           'ALL SEASONS 250ML',
           'ATLAS CAN 16%',
           'Whitecap Lager',
           'BALLANTINES-1Ltr',
           'BALOZI',
           'BEST 750ML',
           'BLACK $ WHITE 375ML',
           'BLACK $ WHITE 750ML',
           'BLACK LABEL 750ML',
           'BLUEICE 250ML',
           'Tusker lager',
           'CAPRICE 1L',
           'CAPTAIN GOLD 250ML',
           'CAPTAIN GOLD 750ML',
           'CHROME 250ML',
           'CHROME 750ML',
           'Guiness lager',
           'Chrome Gin',
           'CLUBMAN 250ML',
           'FAXE 500ML',
           'GENERAL MAKINGS 750ML',
           'GENERAL MEAKINS 250ML',
           'GILBEYS 250ML',
           'GILBEYS 350ML',
           'GILBEYS 750ML',
           'GRANTS 1LTRS',
           'Whitecap light',
           'Guiness Smooth',
           'Pilsner lager',
           'Snapp',
           'GUARANA 330ML',
           'GUINESS CAN',
           'GUINESS SMOOTH',
           'HUNTERS CHHOICE 250ML',
           'JACK DANIELS 1L',
           'KC 350ML',
           'KENYA KING 250ML',
           'KIBAO 250ML',
           'KIBAO 350ML',
           'KIBAO 750ML',
           'KONYAGI 250ML',
           'NAPOLEON 250ML',
           'ORIGIN 250ML',
           'Black ice',
           'PISTON 250ML',
           'RICHOT 350ML',
           'SMIRNOFF 750ML',
           'SODA-1ltr',
           'SWEET BERRY',
           'TRIPPLE ACE 250ML',
           'TUSKER CAN 500ML',
           'TUSKER CIDER CAN',
           'Tusker cider',
           'TUSKER LITE CAN',
           'V$A 750ML',
           'VICEROY 250ML',
           'WHITE PEARL 250ML',
           'WHITECAP CAN'
        ];
        $data = [];
        // $title = [
        //   'Item Name',
        //   'Qty Sold'
        // ];
        $title = [
            'Item Name',
            'Qty Sold'
          ];
        foreach ($products as $p){
            array_push($data,[
                $p,
                rand(1,11)
            ]);
        }
        array_push($data,[
            'TUSKER LITE',
            ($this->rand)
        ]);
        array_push($data,[
            'TUSKER MALT',
            ($this->malt)
        ]);
        $data = collect($data)->shuffle();


        return collect($data);
    }

    public function title(): string
    {
        return  Carbon::parse($this->day.'-8-21')->format('M');
    }

    public function headings(): array
    {
        // return [
        //     'Quiver Lounge',
        //     'Sales Summary Daily',
        //     'Item',
        //     'Quantity'
        // ];
        return [
            ['Quiver Lounge','Sales Summary Daily'],
            ['Product','Item']
        ];
    }
}
