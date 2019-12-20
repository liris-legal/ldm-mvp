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
         $this->call(CategoryCaseSeeder::class);
         $this->call(CategoryDocumentSeeder::class);
         $this->call(CasesSeeder::class);
         $this->call(PlaintiffSeeder::class);
         $this->call(PlaintiffAgentSeeder::class);
         $this->call(DefendantAgentSeeder::class);
         $this->call(DefendantSeeder::class);
         $this->call(DocumentSeeder::class);
    }
}
