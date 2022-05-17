<?php

namespace App\Scopes;

use App;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class SaccoScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        return;
        if(!Sentinel::check()){
            return;
        }

        if($name = Route::currentRouteName() == 'client_login'){
            return;
        };

        $user = Sentinel::getUser();


//        die;
        $sacco_id = $user->sacco_id;
        if (empty($sacco_id)) {
            return;
        }
//die;
//        $role = Sentinel::inRole('admin');
        if($role = Sentinel::inRole('admin')){
            return;
        }
//die;
        $table = $model->getTable();
//        Log::info($table);


        // Skip for specific tables
        $skip_tables = ['jobs', 'migrations', 'sessions'];
        if (in_array($table, $skip_tables)) {
            return;
        }

        // Skip if already exists
        if ($this->exists($builder, 'sacco_id')) {
            return;
        }


//        $builder->where($table . '.sacco_id', '=', $sacco_id);
//         print_r($builder->getBindings());die;
    }

    /**
     * Check if scope exists.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  $column
     * @return boolean
     */
    protected function exists($builder, $column)
    {
        $query = $builder->getQuery();

        foreach ((array) $query->wheres as $key => $where) {
            if (empty($where) || empty($where['column'])) {
                continue;
            }

            if (strstr($where['column'], '.')) {
                $whr = explode('.', $where['column']);

                $where['column'] = $whr[1];
            }

            if ($where['column'] != $column) {
                continue;
            }

            return true;
        }

        return false;
    }
}
