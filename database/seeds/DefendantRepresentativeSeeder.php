<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefendantRepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'defendant_representatives';

        Schema::disableForeignKeyConstraints();
        $time = Carbon\Carbon::now();

        DB::table($table)->truncate();
        $rows = [
            [ 'PQRST法律事務所', 1, $time],
            [ 'PQRST法律事務所', 2, $time],
        ];
        foreach ($rows as $row) {
            DB::table($table)->insert([
                'name' => $row[0],
                'lawsuit_id' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
