<?php

namespace App\Providers;

use App\Models\MpesaPayment;
use App\Models\Sacco;
use App\Models\Trip;
use App\Observers\MpesaPaymentObserver;
use App\Observers\SaccoCreatedObserver;
use App\Observers\TripObserver;
use Illuminate\Support\ServiceProvider;
use Safaricom\Mpesa\Mpesa;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sacco::observe(SaccoCreatedObserver::class);
        Trip::observe(TripObserver::class);
        MpesaPayment::observe(MpesaPaymentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
