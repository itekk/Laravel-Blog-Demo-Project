<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name'  => 'Test',
            'email'      => 'admin@yopmail.com',
            'password'   => Hash::make('test1234'),
            'user_type'  => 'admin'
        ]);
    }
}
