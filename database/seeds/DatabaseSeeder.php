<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(TypeAuthorSeed::class);
         $this->call(TypeCaseSeeder::class);
         $this->call(TypeDocumentSeeder::class);
         $this->call(CasesSeeder::class);
         $this->call(PlaintiffSeeder::class);
         $this->call(PlaintiffRepresentativeSeeder::class);
         $this->call(DefendantRepresentativeSeeder::class);
         $this->call(DefendantSeeder::class);
         $this->call(DocumentSeeder::class);
    }
}
