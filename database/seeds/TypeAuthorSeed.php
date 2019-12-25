<?php

use Illuminate\Database\Seeder;

class TypeAuthorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_authors')->insert([
            [ 'id' => '1' ,'name' => '原告', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2' ,'name' => '被告', 'created_at' => '2019-11-26 19:21:40', 'updated_at' => '2019-11-26 19:21:40' ],
            [ 'id' => '3' ,'name' => '裁判所', 'created_at' => '2019-11-26 19:21:41', 'updated_at' => '2019-11-26 19:21:41' ],
            [ 'id' => '4' ,'name' => 'その他', 'created_at' => '2019-11-26 19:21:42', 'updated_at' => '2019-11-26 19:21:42' ],
        ]);
    }
}
