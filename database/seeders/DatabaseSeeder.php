<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $this->call(MasterSeeder::class);

        DB::table('users')->insert([
            array('id' => 1, 'code'=>'sys','name' => 'System Admin', 'email' => 'super@gmail.com','user_level'=>1,'password' => \Hash::make('123456'),'created_at'=>$now),
        ]);
    }
}
