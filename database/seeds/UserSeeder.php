<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $time = Carbon\Carbon::now();

        DB::table('users')->truncate();
        $rows = [
            ['8968e76a-4945-40e8-a77a-29261f7cd2f3', 'thai.le.connectiv@gmail.com', $time ],
            ['271d6beb-be76-48d7-bb93-24db5c408c8c', 'cong.du.connectiv+_1@gmail.com', $time ],
        ];
        foreach ($rows as $row) {
            DB::table('users')->insert([
                'cognito_username' => $row[0],
                'email' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
