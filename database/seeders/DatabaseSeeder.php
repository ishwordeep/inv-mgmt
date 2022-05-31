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

        DB::table('users')->insert([
            array('id' => 1, 'name' => 'System Admin', 'email' => 'super@gmail.com','user_level'=>config('users.user_level.super_user'),'password' => \Hash::make('123456'),'created_at'=>$now),
        ]);
    }
}
