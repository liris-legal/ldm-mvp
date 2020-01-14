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
            $table->unsignedInteger('lawsuit_id');
            $table->timestamps();

            $table->foreign('lawsuit_id')->references('id')->on('lawsuits')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE defendants CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT FIRST');
        DB::statement('ALTER TABLE defendants CHANGE lawsuit_id lawsuit_id int(6) zerofill NOT NULL');
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
