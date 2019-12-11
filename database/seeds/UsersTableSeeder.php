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
            ['name' => 'user1', 'email' => 'user1.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['name' => 'user2', 'email' => 'user2.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['name' => 'user3', 'email' => 'user3.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['name' => 'user4', 'email' => 'user4.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
            ['name' => 'user5', 'email' => 'cong.du.connectiv@gmail.com', 'password' => bcrypt('connectiv'),],
        ]);
    }
}
