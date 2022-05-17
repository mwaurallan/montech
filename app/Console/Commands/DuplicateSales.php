<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class DuplicateSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $products = [
        '4TH STREET 750ML RED',
        'ALL SEASONS 250ML',
        'ATLAS CAN 16%',
        'BALLANTINES-1Ltr',
        'BALOZI',
        'BEST 750ML',
        'BLACK $ WHITE 375ML',
        'BLACK $ WHITE 750ML',
        'BLACK LABEL 750ML',
        'BLUEICE 250ML',
        'CAPRICE 1L',
        'CAPTAIN GOLD 250ML',
        'CAPTAIN GOLD 750ML',
        'CHROME 250ML',
        'CHROME 750ML',
        'Chrome Gin',
        'CLUBMAN 250ML',
        'FAXE 500ML',
        'GENERAL MAKINGS 750ML',
        'GENERAL MEAKINS 250ML',
        'GILBEYS 250ML',
        'GILBEYS 350ML',
        'GILBEYS 750ML',
        'GRANTS 1LTRS',
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
        'PISTON 250ML',
        'RICHOT 350ML',
        'SMIRNOFF 750ML',
        'SODA-1ltr',
        'SWEET BERRY',
        'TRIPPLE ACE 250ML',
        'TUSKER CAN 500ML',
        'TUSKER CIDER CAN',
        'TUSKER LITE CAN',
        'TUSKER LITE',
        'TUSKER MALT',
        'V$A 750ML',
        'VICEROY 250ML',
        'WHITE PEARL 250ML',
        'WHITECAP CAN'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
