<?php

use Illuminate\Database\Seeder;

class AdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'password' => bcrypt('letmein'),
        ]);
    }
}
