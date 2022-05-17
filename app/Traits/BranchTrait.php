<?php

namespace App\Traits;

use App\Observers\SaccoObserver;
use Illuminate\Support\Facades\Log;

trait BranchTrait
{

    /**
     * boot global scope
     *
     * @return string
     */

    public static function bootBranchTrait()
    {
        static::addGlobalScope(new \App\Scopes\BranchScope());

        static::observe(new SaccoObserver());
    }



}
