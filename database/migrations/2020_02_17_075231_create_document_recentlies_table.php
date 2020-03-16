<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRecentliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_recentlies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('document_id')->nullable();
            $table->integer('number')->nullable();
            $table->integer('subnumber')->nullable();
            $table->string('name')->nullable();
            $table->unsignedInteger('lawsuit_id')->nullable();
            $table->unsignedInteger('type_document_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('document_id')->references('id')->on('documents')
                ->onDelete('cascade')->onUpdate('cascade');
        });
        DB::statement('ALTER TABLE document_recentlies CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT NOT NULL');
        DB::statement('ALTER TABLE document_recentlies CHANGE user_id user_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE document_recentlies CHANGE document_id document_id int(6) zerofill NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_recentlies');
    }
}
