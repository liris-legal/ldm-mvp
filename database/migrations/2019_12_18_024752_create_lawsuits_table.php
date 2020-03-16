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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('type_lawsuit_id');
            $table->string('number');
            $table->string('name');
            $table->string('courts_departments')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_lawsuit_id')->references('id')->on('type_lawsuits')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE lawsuits CHANGE user_id user_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE lawsuits CHANGE type_lawsuit_id type_lawsuit_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE lawsuits CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT FIRST');
        DB::statement('ALTER TABLE lawsuits AUTO_INCREMENT = 100000');
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
