<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
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

        DB::table('documents')->truncate();
        $rows = [
            [ 'PQRST法律事務所', 'https://www.soundczech.cz/temp/lorem-ipsum-1.pdf', '00001', 1, 1, $time],
            [ 'ABCDE法律事務所', 'https://www.soundczech.cz/temp/lorem-ipsum-2.pdf', '00002', 2, 2, $time],
            [ 'XYZTW法律事務所', 'https://www.soundczech.cz/temp/lorem-ipsum-3.pdf', '00003', 3, 3, $time],
            [ 'NMBVC法律事務所', 'https://www.soundczech.cz/temp/lorem-ipsum-4.pdf', '00004', 4, 4, $time],
        ];
        foreach ($rows as $row) {
            DB::table('documents')->insert([
                'name' => $row[0],
                'url' => $row[1],
                'number' => $row[2],
                'submitter_id' => $row[3],
                'type_document_id' => $row[4],
                'created_at' => $row[5],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
