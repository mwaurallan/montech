<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class OtherPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perms = [
          'vehicles','branches','bank','stock','memberVehicles',
            'fieldSavingTransactions',
            'invoices',
            'invoicePayments',
            'mpesaPayments',
            'processedMpesaPayments'
        ];

        //cashlessPermissions
        $cashless = \App\Models\Permission::firstOrCreate([
            'parent_id' => 0,
            'name' => 'Cashless Payments',
            'slug' => 'cashless',
            'description' => 'Access Cashless Payments Module'
        ]);
        $cashlessPerms = [
            'trips','payments','tripPayments'
        ];


        $actions = [
            'View',
            'Create',
            'Update',
            'Delete',
        ];

        $role = Sentinel::findRoleById(1);
        $role->updatePermission($cashless->id, true, true)->save();
        foreach ($cashlessPerms as $perm){
//            $m = \App\Models\Permission::firstOrCreate([
//                'parent_id' => 0,
//                'name' => ucwords($perm),
//                'slug' => $perm,
//                'description' => 'Access '.$perm
//            ]);
            foreach ($actions as $action){
                $p = \App\Models\Permission::firstOrCreate([
                    'parent_id' => $cashless->id,
                    'name' => $action.' '.ucwords($perm),
                    'slug' => $perm.'.'.strtolower($action),
                    'description' => $action.' '.$perm
                ]);

                $role->updatePermission($p->id, true, true)->save();
            }

        }


        foreach ($perms as $perm){
//            $role = Sentinel::findRoleById(1);
            $m = \App\Models\Permission::firstOrCreate([
                'parent_id' => 0,
                'name' => ucwords($perm),
                'slug' => $perm,
                'description' => 'Access '.$perm
            ]);
            $role->updatePermission($m->id, true, true)->save();
            foreach ($actions as $action){
                $p = \App\Models\Permission::firstOrCreate([
                    'parent_id' => $m->id,
                    'name' => $action.' '.ucwords($perm),
                    'slug' => $perm.'.'.strtolower($action),
                    'description' => $action.' '.$perm
                ]);

                $role->updatePermission($p->id, true, true)->save();
            }

        }

        $m = \App\Models\Permission::firstOrCreate([
            'parent_id' => 1,
            'name' => 'Blacklist Borrowers',
            'slug' => 'borrowers.blacklist',
            'description' => 'Blacklist borrowers'
        ]);
        $m = \App\Models\Permission::firstOrCreate([
            'parent_id' => \App\Models\Permission::where('slug','branches')->first()->id,
            'name' => 'Assign Branches',
            'slug' => 'branches.assign',
            'description' => ''
        ]);
        $m = \App\Models\Permission::firstOrCreate([
            'parent_id' => 1,
            'name' => ' Borrowers Groups',
            'slug' => 'borrowers.groups',
            'description' => 'borrower groups'
        ]);
        $m = \App\Models\Permission::firstOrCreate([
            'parent_id' => 1,
            'name' => 'Blacklist Borrowers',
            'slug' => 'borrowers.blacklist',
            'description' => 'Blacklist borrowers'
        ]);
    }
}
