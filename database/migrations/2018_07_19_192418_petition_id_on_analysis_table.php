<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PetitionIdOnAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analysis', function (Blueprint $table) {
            $table->integer('petition_id')->unsigned()->after('volunteer_id');
        });

        Schema::table('analysis', function (Blueprint $table) {
            $table->foreign('petition_id')->references('id')->on('petitions')->onDelete('cascade');
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
