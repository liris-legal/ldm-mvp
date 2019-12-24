<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('defendants')->insert([
            [ 'id' => '1' ,'name' => 'KLMNO株式会社', 'type_author_id' => '2', 'case_id' => '1', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2' ,'name' => 'LMNOP株式会社', 'type_author_id' => '2', 'case_id' => '2', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
        ]);
    }
}
