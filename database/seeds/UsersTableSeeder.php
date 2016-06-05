<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		'sdu_id' => 0,
    		'email' => 'admin@mail.com',
    		'password' => bcrypt('1234'),
            'firstname' => 'Admin',
            'role' => 'admin',
            'avatar' => sprintf('avatar_0%s.png', rand(1,8))
        ]);
    }
}
