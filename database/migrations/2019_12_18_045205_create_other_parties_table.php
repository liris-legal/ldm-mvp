<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_parties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('lawsuit_id');
            $table->timestamps();

            $table->foreign('lawsuit_id')->references('id')->on('lawsuits')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE other_parties CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT NOT NULL');
        DB::statement('ALTER TABLE other_parties CHANGE lawsuit_id lawsuit_id int(6) zerofill NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_parties');
    }
}
