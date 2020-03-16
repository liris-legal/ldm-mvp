<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lawsuit_id');
            $table->unsignedInteger('type_document_id');
            $table->unsignedInteger('submitter_id');
            $table->integer('documentable_id')->nullable();
            $table->string('documentable_type')->nullable();
            $table->string('name');
            $table->integer('number')->nullable();
            $table->integer('subnumber')->nullable();
            $table->string('url')->unique();
            $table->timestamps();

            $table->foreign('lawsuit_id')->references('id')->on('lawsuits')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_document_id')->references('id')->on('type_documents')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('submitter_id')->references('id')->on('submitters')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE documents CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT NOT NULL');
        DB::statement('ALTER TABLE documents CHANGE lawsuit_id lawsuit_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE documents CHANGE submitter_id submitter_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE documents CHANGE type_document_id type_document_id int(6) zerofill NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
