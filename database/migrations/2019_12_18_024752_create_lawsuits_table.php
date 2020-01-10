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
            $table->unsignedInteger('type_lawsuit_id');
            $table->string('number')->unique();
            $table->string('name');
            $table->string('courts_departments')->nullable();
            $table->timestamps();

            $table->foreign('type_lawsuit_id')->references('id')->on('type_lawsuits')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE lawsuits CHANGE type_lawsuit_id type_lawsuit_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE lawsuits CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT FIRST');
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
