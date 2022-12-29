<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'first_name' => "UMUHIRE",
            'last_name' => "HERITIER",
            'role'=>"ADMIN",
            'email'=>'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}