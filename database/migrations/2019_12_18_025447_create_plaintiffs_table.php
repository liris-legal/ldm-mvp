<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaintiffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaintiffs', function (Blueprint $table) {
            $table->bigIncrements('id')->start_from(100000);
            $table->string('name');
            $table->unsignedInteger('lawsuit_id');
            $table->unsignedInteger('submitter_id');
            $table->timestamps();

            $table->foreign('lawsuit_id')->references('id')->on('lawsuits')->onDelete('cascade');
            $table->foreign('submitter_id')->references('id')->on('submitters')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE plaintiffs CHANGE id id int(6) zerofill NOT NULL AUTO_INCREMENT FIRST');
        DB::statement('ALTER TABLE plaintiffs AUTO_INCREMENT = 100000');
        DB::statement('ALTER TABLE plaintiffs CHANGE lawsuit_id lawsuit_id int(6) zerofill NOT NULL');
        DB::statement('ALTER TABLE plaintiffs CHANGE submitter_id submitter_id int(6) zerofill NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plaintiffs');
    }
}
