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
            ['first_name' => 'user1', 'last_name' => 'connectiv', 'email' => 'user1.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['first_name' => 'user2', 'last_name' => 'connectiv', 'email' => 'user2.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['first_name' => 'user3', 'last_name' => 'connectiv', 'email' => 'user3.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['first_name' => 'user4', 'last_name' => 'connectiv', 'email' => 'user4.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['first_name' => 'user5', 'last_name' => 'connectiv', 'email' => 'cong.du.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
        ]);
    }
}
