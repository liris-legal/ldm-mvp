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
        Schema::disableForeignKeyConstraints();
        $time = Carbon\Carbon::now();

        DB::table('lawsuits')->truncate();
        $rows = [
            [ 1, '00001', '損害賠償請求01 事件', '東京地方裁判所', $time],
            [ 1, '00002', '損害賠償請求02 事件', '東京地方裁判所', $time],
        ];
        foreach ($rows as $row) {
            DB::table('lawsuits')->insert([
                'type_lawsuit_id' => $row[0],
                'number' => $row[1],
                'name' => $row[2],
                'courts_departments' => $row[3],
                'created_at' => $row[4],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
