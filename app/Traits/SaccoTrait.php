<?php

namespace App\Traits;

use App\Observers\SaccoObserver;
use Illuminate\Support\Facades\Log;

trait SaccoTrait
{

    /**
     * boot global scope
     *
     * @return string
     */

    public static function bootSaccoTrait()
    {
//        static::addGlobalScope(new \App\Scopes\SaccoScope());
        static::observe(new SaccoObserver());
    }



}
