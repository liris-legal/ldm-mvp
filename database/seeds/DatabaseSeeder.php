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
         $this->call(SubmitterSeeder::class);
         $this->call(TypeLawsuitSeeder::class);
         $this->call(TypeDocumentSeeder::class);
         $this->call(LawsuitSeeder::class);
         $this->call(PlaintiffSeeder::class);
         $this->call(PlaintiffRepresentativeSeeder::class);
         $this->call(DefendantRepresentativeSeeder::class);
         $this->call(DefendantSeeder::class);
         $this->call(DocumentSeeder::class);
    }
}
