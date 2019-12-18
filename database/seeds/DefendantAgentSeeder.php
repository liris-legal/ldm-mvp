<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefendantAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('defendant_agents')->insert([
            [ 'id' => '1' ,'name' => 'PQRST法律事務所', 'case_id' => '1', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2' ,'name' => 'XYZTW法律事務所', 'case_id' => '2', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
        ]);
    }
}
