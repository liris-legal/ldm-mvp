<?php

use Illuminate\Database\Seeder;

class CategoryDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_documents')->insert([
            [ 'id' => '1', 'name' => '主張書面', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2', 'name' => '証拠書面', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '3', 'name' => 'その他の書面', 'created_at' => '2019-11-26 19:21:40', 'updated_at' => '2019-11-26 19:21:40' ],
        ]);
    }
}
