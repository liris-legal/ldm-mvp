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
        Schema::disableForeignKeyConstraints();
        $time = Carbon\Carbon::now();

        DB::table('defendants')->truncate();
        $rows = [
            [ 'KLMNO株式会社', 2, 1, $time],
            [ 'LMNOP株式会社', 2, 2, $time],
        ];
        foreach ($rows as $row) {
            DB::table('defendants')->insert([
                'name' => $row[0],
                'submitter_id' => $row[1],
                'lawsuit_id' => $row[2],
                'created_at' => $row[3],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
