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
            [ '00001', 1, 1, 1, '訴状', '9415595560b7536-訴状サンプル.pdf', $time],
            [ '00001', 1, 2, 1, '証拠説明書', '2a47ed33f9c9d8c-証拠説明書サンプル.pdf', $time],
            [ '00001', 6, 3, 1, '期日経過報告書', '61d33bdd4f6df79-期日経過報告書サンプル.pdf', $time],
            [ '00001', 1, 1, 1, '答弁書', 'fdeece3b32c1c72-答弁書サンプル.pdf', $time],
            [ '00001', 1, 2, 1, '甲号証', '2020011706013331-証拠説明書サンプル.pdf', $time],
            
        ];
        foreach ($rows as $row) {
            DB::table('documents')->insert([
                'lawsuit_id' => $row[0],
                'submitter_id' => $row[1],
                'type_document_id' => $row[2],
                'number' => $row[3],
                'name' => $row[4],
                'url' => $row[5],
                'created_at' => $row[6],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
