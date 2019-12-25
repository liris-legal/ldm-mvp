<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawsuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawsuits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('type_case_id');
            $table->string('number')->unique();
            $table->string('name');
            $table->string('courts_departments')->nullable();
            $table->timestamps();

            $table->foreign('type_case_id')->references('id')->on('type_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lawsuits');
    }
}
