<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis', function (Blueprint $table){
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->text('analisys_text');
            $table->text('referral_law');
            $table->text('law_link');
            $table->text('percent_votes');
            $table->text('vote_number');
            $table->text('minimum_signatures');
        });

        Schema::table('analysis', function($table) {
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analysis');
    }
}
