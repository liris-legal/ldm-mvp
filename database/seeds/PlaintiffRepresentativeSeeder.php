<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaintiffRepresentativeSeeder extends Seeder
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

        DB::table('plaintiff_representatives')->truncate();
        $rows = [
            [ 'FGHIJ法律事務所', 1, $time],
            [ 'FGHIJ法律事務所', 2, $time],
        ];
        foreach ($rows as $row) {
            DB::table('plaintiff_representatives')->insert([
                'name' => $row[0],
                'lawsuit_id' => $row[1],
                'created_at' => $row[2],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
