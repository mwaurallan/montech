<?php

namespace App\Observers;

use App\Models\MemberVehicle;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

class TripObserver
{
    /**
     * Handle the trip "created" event.
     *
     * @param  \App\models\Trip  $trip
     * @return void
     */
    public function created(Trip $trip)
    {

    }

    /**
     * Handle the trip "updated" event.
     *
     * @param  \App\Trip  $trip
     * @return void
     */
    public function updated(Trip $trip)
    {
        //
    }

    /**
     * Handle the trip "deleted" event.
     *
     * @param  \App\Trip  $trip
     * @return void
     */
    public function deleted(Trip $trip)
    {
        //
    }

    /**
     * Handle the trip "restored" event.
     *
     * @param  \App\Trip  $trip
     * @return void
     */
    public function restored(Trip $trip)
    {
        //
    }

    /**
     * Handle the trip "force deleted" event.
     *
     * @param  \App\Trip  $trip
     * @return void
     */
    public function forceDeleted(Trip $trip)
    {
        //
    }
}
