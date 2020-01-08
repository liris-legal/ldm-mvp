<?php

use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
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

        DB::table('type_documents')->truncate();
        $rows = [
            [ '主張書面', 'claim', $time],
            [ '証拠書面', 'evidence', $time],
            [ 'その他の書面', 'other', $time],
        ];
        foreach ($rows as $row) {
            DB::table('type_documents')->insert([
                'name' => $row[0],
                'description' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
