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
        DB::table('documents')->insert([
            [ 'id' => '1', 'case_id' => '1', 'category_document_id' => '1', 'name' => 'PQRST法律事務所', 'url' => 'https://www.soundczech.cz/temp/lorem-ipsum.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2', 'case_id' => '1', 'category_document_id' => '2', 'name' => 'ABCDE法律事務所', 'url' => 'http://www.bavtailor.com/wp-content/uploads/2018/10/Lorem-Ipsum.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '3', 'case_id' => '1', 'category_document_id' => '3', 'name' => 'XYZTW法律事務所', 'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:40', 'updated_at' => '2019-11-26 19:21:40' ],
            [ 'id' => '4', 'case_id' => '1', 'category_document_id' => '1', 'name' => 'NMBVC法律事務所', 'url' => 'http://www.buds.com.ua/images/Lorem_ipsum.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:41', 'updated_at' => '2019-11-26 19:21:41' ],
            [ 'id' => '5', 'case_id' => '1', 'category_document_id' => '3', 'name' => 'XXXXX法律事務所', 'url' => 'https://peda.net/kangasala/pikkolan-koulu/atk/janne-v/atk8/osat/lt/pdf-tiedosto:file/download/cfdda9498f9e910fdcb763ec989d116e8753dc7c/loremipsum.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:42', 'updated_at' => '2019-11-26 19:21:42' ],
            [ 'id' => '6', 'case_id' => '1', 'category_document_id' => '2', 'name' => 'NNNNN法律事務所', 'url' => 'https://injaz-saudi.org/wp-content/uploads/2019/04/TestPDF-1.pdf?x95971', 'author' => '原告', 'created_at' => '2019-11-26 19:21:43', 'updated_at' => '2019-11-26 19:21:43' ],
            [ 'id' => '7', 'case_id' => '1', 'category_document_id' => '2', 'name' => 'CCCCC法律事務所', 'url' => 'https://pdfobject.com/pdf/sample.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:44', 'updated_at' => '2019-11-26 19:21:44' ],
            [ 'id' => '8', 'case_id' => '1', 'category_document_id' => '1', 'name' => 'XXXYY法律事務所', 'url' => 'http://www.africau.edu/images/default/sample.pdf', 'author' => '原告', 'created_at' => '2019-11-26 19:21:45', 'updated_at' => '2019-11-26 19:21:45' ],
        ]);
    }
}
