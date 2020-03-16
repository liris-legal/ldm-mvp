<?php

use Illuminate\Database\Seeder;

class TypeLawsuitSeeder extends Seeder
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

        DB::table('type_lawsuits')->truncate();
        $rows = [
            ['民事事件', 'civil lawsuits', $time ],
        ];
        foreach ($rows as $row) {
            DB::table('type_lawsuits')->insert([
                'name' => $row[0],
                'description' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
