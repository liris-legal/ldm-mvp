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
            [ '00001', 1, 1, null, '準備書面１',  '5cbe43b60f-ツカミ.pdf', $time],
            [ '00001', 3, 1, null, '答弁書', '2af8c993e7-ツカミ.pdf', $time],
            [ '00001', 1, 1, null, '訴状', '27dd155b09-ツカミ.pdf', $time],
            [ '00001', 5, 3, null, '期日経過報告書', '71a01f5f97-ツカミ.pdf', $time],
            [ '00001', 1, 2, 1, '証拠説明書', '5cbe43b60a-ツカミ.pdf', $time],
            [ '00001', 1, 2, 4, '甲号証', '5cbe43b61f-ツカミ.pdf', $time],
            [ '00001', 1, 2, 3, '甲号証', '5cbe43b62f-ツカミ.pdf', $time],
            [ '00001', 1, 2, 2, '甲号証', '5cbe43b63f-ツカミ.pdf', $time],
            [ '00001', 1, 2, 1, '甲号証', '5cbe43b64f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 1, '証拠説明書', '5cbe45b60f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 5, '乙号証', '5cbe43b66f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 4, '乙号証', '5cbe43b67f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 3, '乙号証', '5cbe43b68f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 2, '乙号証', '5cbe43b69f-ツカミ.pdf', $time],
            [ '00001', 3, 2, 1, '乙号証', '5cbe43b6xf-ツカミ.pdf', $time],
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
