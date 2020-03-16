<?php

use Illuminate\Database\Seeder;

class SubmitterSeeder extends Seeder
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

        DB::table('submitters')->truncate();
        $rows = [
            [ '原告', 'plaintiff', $time],
            [ '原告代理人', 'plaintiff_representative', $time],
            [ '被告', 'defendant', $time],
            [ '被告代理人', 'defendant_representative', $time],
            [ '裁判所', 'court', $time],
            [ 'その他', 'other_party', $time],
        ];
        foreach ($rows as $row) {
            DB::table('submitters')->insert([
                'name' => $row[0],
                'description' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
