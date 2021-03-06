<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::transaction(function (){
            $this->call(RolesTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(SettingsTableSeeder::class);
            $this->call(CountryTableSeeder::class);
            $this->call(PayrollTemplateTableSeeder::class);
            $this->call(OtherPermissionsSeeder::class);
            $this->call(MessageTemplateSeeder::class);

        });

    }
}
