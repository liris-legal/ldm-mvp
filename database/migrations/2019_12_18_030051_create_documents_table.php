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
            $table->string('number');
            $table->string('name')->unique();
            $table->string('url')->unique();
            $table->unsignedInteger('type_document_id');
            $table->unsignedInteger('type_author_id');
            $table->timestamps();

            $table->foreign('type_author_id')->references('id')->on('type_authors')->onDelete('cascade');
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
        });
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
