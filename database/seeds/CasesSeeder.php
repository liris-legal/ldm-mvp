<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cases')->insert([
            [ 'id' => '1' ,'category_id' => '1', 'number' => '平成31年（ワ）第○○号', 'name' => '損害賠償請求事件', 'courts' => '東京地方裁判所', 'other_parties' => '', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2' ,'category_id' => '1', 'number' => '平成32年（ワ）第○○号', 'name' => '損害賠償請求事件2', 'courts' => '東京地方裁判所', 'other_parties' => '', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
        ]);
    }
}
