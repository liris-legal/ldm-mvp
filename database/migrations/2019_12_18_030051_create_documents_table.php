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
            $table->unsignedBigInteger('case_id');
            $table->unsignedInteger('category_document_id');
            $table->string('name')->unique();
            $table->string('url')->unique();
            $table->string('author');
            $table->timestamps();

            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
            $table->foreign('category_document_id')->references('id')->on('category_documents')->onDelete('cascade');
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
