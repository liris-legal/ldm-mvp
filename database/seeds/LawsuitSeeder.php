<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LawsuitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lawsuits')->insert([
            [ 'id' => '1' ,'type_lawsuit_id' => '1', 'number' => '平成31年（ワ）第○○号', 'name' => '損害賠償請求事件', 'courts_departments' => '東京地方裁判所', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2' ,'type_lawsuit_id' => '1', 'number' => '平成32年（ワ）第○○号', 'name' => '損害賠償請求事件2', 'courts_departments' => '東京地方裁判所', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
        ]);
    }
}
