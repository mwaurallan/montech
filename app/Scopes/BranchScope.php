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
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class BranchScope implements Scope
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
        if(!Sentinel::check()){
            return;
        }

        if($name = Route::currentRouteName() == 'client_login'){
            return;
        };

        if(!Session::has('branch_id')){
            return;
        }
        if(Session::has('uid')){
            return;
        }



//        Log::info(Session::all());
        $branch_id = Session::get('branch_id');

        if (empty($branch_id)) {
            return;
        }
        $table = $model->getTable();
        if(!Schema::hasColumn($model->getTable(), 'branch_id')){
            return;
        }


        // Skip for specific tables
        $skip_tables = ['jobs', 'migrations', 'sessions'];
        if (in_array($table, $skip_tables)) {
            return;
        }

        // Skip if already exists
        if ($this->exists($builder, 'branch_id')) {
            return;
        }
        $builder->where($table . '.branch_id', '=', $branch_id);
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
