<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefendantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defendants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('submitter_id');
            $table->unsignedBigInteger('lawsuit_id');
            $table->timestamps();

            $table->foreign('lawsuit_id')->references('id')->on('lawsuits')->onDelete('cascade');
            $table->foreign('submitter_id')->references('id')->on('submitters')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defendants');
    }
}
