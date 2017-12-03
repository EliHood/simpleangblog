<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	User::truncate();

        User::create([
        	'name' => 'Eli Hood', 
        	'email' => 'eli.hood@aol.com',
        	'password' => Hash::make('12345'), 
        	'remember_token' => str_random(10), 

        ]);
    }
}
