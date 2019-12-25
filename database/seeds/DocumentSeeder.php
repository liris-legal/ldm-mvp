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
            [ 'id' => '1', 'name' => 'PQRST法律事務所', 'url' => 'https://www.soundczech.cz/temp/lorem-ipsum.pdf', 'number' => '平成31年（ワ）○○号', 'submitter_id' => '1', 'type_document_id' => '1', 'created_at' => '2019-11-26 19:21:38', 'updated_at' => '2019-11-26 19:21:38' ],
            [ 'id' => '2', 'name' => 'ABCDE法律事務所', 'url' => 'http://www.bavtailor.com/wp-content/uploads/2018/10/Lorem-Ipsum.pdf', 'submitter_id' => '1', 'type_document_id' => '2', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '3', 'name' => 'XYZTW法律事務所', 'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf', 'submitter_id' => '2', 'type_document_id' => '3', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '4', 'name' => 'NMBVC法律事務所', 'url' => 'http://www.buds.com.ua/images/Lorem_ipsum.pdf', 'submitter_id' => '1', 'type_document_id' => '3', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '5', 'name' => 'XXXXX法律事務所', 'url' => 'https://peda.net/kangasala/pikkolan-koulu/atk/janne-v/atk8/osat/lt/pdf-tiedosto:file/download/cfdda9498f9e910fdcb763ec989d116e8753dc7c/loremipsum.pdf', 'submitter_id' => '1', 'type_document_id' => '2', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '6', 'name' => 'NNNNN法律事務所', 'url' => 'https://injaz-saudi.org/wp-content/uploads/2019/04/TestPDF-1.pdf?x95971', 'submitter_id' => '1', 'type_document_id' => '2', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '7', 'name' => 'CCCCC法律事務所', 'url' => 'https://pdfobject.com/pdf/sample.pdf', 'submitter_id' => '2', 'type_document_id' => '1', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
            [ 'id' => '8', 'name' => 'XXXYY法律事務所', 'url' => 'http://www.africau.edu/images/default/sample.pdf', 'submitter_id' => '4', 'type_document_id' => '2', 'number' => '平成31年（ワ）○○号', 'created_at' => '2019-11-26 19:21:39', 'updated_at' => '2019-11-26 19:21:39' ],
        ]);
    }
}
