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
            [ '原告', $time],
            [ '被告', $time],
            [ '裁判所', $time],
            [ 'その他', $time],
        ];
        foreach ($rows as $row) {
            DB::table('submitters')->insert([
                'name' => $row[0],
                'created_at' => $row[1],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
