<?php

use Illuminate\Database\Seeder;

class TypeCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_cases')->insert([
            [ 'id' => '1', 'name' => '民事事件', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
        ]);
    }
}
