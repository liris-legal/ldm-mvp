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
            [ '00001', 1, 1, 1, null, '訴状', 3, 'App\Models\Plaintiff', '2020011803014931-訴状サンプル.pdf', $time],
            [ '00001', 3, 2, 1, null, '証拠説明書', 1, 'App\Models\Defendant', '2020011803013631-証拠説明書サンプル.pdf', $time],
            [ '00001', 6, 3, 1, null, '期日経過報告書', null, null, '2020011803015131-期日経過報告書サンプル.pdf', $time],
            [ '00001', 1, 1, 1, null, '答弁書', 3, 'App\Models\Plaintiff', '2020011803015531-答弁書サンプル.pdf', $time],
            [ '00001', 1, 2, 1, 1, '甲号証', 1, 'App\Models\Plaintiff', '2020011803012231-証拠説明書サンプル.pdf', $time],
            [ '00001', 1, 2, 1, 2, '甲号証', 1, 'App\Models\Plaintiff', '2020013007011731-証拠説明書サンプル.pdf', $time],
            [ '00001', 1, 2, 2, 1, '甲号証', 2, 'App\Models\Plaintiff', '2020013006013931-証拠説明書サンプル.pdf', $time],
            [ '00001', 1, 2, 1, null, '証拠説明書', 1, 'App\Models\Plaintiff', '2020011803013931-証拠説明書サンプル.pdf', $time],
        ];
        foreach ($rows as $row) {
            DB::table('documents')->insert([
                'lawsuit_id' => $row[0],
                'submitter_id' => $row[1],
                'type_document_id' => $row[2],
                'number' => $row[3],
                'subnumber' => $row[4],
                'name' => $row[5],
                'documentable_id' => $row[6],
                'documentable_type' => $row[7],
                'url' => $row[8],
                'created_at' => $row[9],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
