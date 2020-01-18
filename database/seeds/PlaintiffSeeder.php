<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaintiffSeeder extends Seeder
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

        DB::table('plaintiffs')->truncate();
        $rows = [
            [ 'ABCDE株式会社', 1, 1, $time],
            [ 'ABHGJ株式会社', 2, 1, $time],
            [ 'JJKDE株式会社', 1, 1, $time],
        ];
        foreach ($rows as $row) {
            DB::table('plaintiffs')->insert([
                'name' => $row[0],
                'lawsuit_id' => $row[1],
                'submitter_id' => $row[2],
                'created_at' => $row[3],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
