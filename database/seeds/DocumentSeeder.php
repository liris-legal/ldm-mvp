<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert([
            [ 'id' => '1', 'case_id' => '1','name' => 'PQRST法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2', 'case_id' => '1','name' => 'ABCDE法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '3', 'case_id' => '1','name' => 'XYZTW法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:40', 'updated_at' => '2019-11-26 19:21:40' ],
            [ 'id' => '4', 'case_id' => '1','name' => 'NMBVC法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:41', 'updated_at' => '2019-11-26 19:21:41' ],
            [ 'id' => '5', 'case_id' => '1','name' => 'XXXXX法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:42', 'updated_at' => '2019-11-26 19:21:42' ],
            [ 'id' => '6', 'case_id' => '1','name' => 'NNNNN法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:43', 'updated_at' => '2019-11-26 19:21:43' ],
            [ 'id' => '7', 'case_id' => '1','name' => 'CCCCC法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:44', 'updated_at' => '2019-11-26 19:21:44' ],
            [ 'id' => '8', 'case_id' => '1','name' => 'XXXYY法律事務所', 'author' => '原告', 'created_at' => '2019-11-26 19:21:45', 'updated_at' => '2019-11-26 19:21:45' ],
        ]);
    }
}
