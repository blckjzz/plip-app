<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petitions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('plip_status');
            $table->text('template');
            $table->text('fantasy_name');
            $table->text('name');
            $table->text('text');
            $table->text('wide');
            $table->text('state');
            $table->text('municipality');
            $table->text('video_url');
            $table->text('references');
            $table->text('links');
            $table->text('sender_name');
            $table->text('sender_mail');
            $table->text('sender_telephone');
            $table->text('submitDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
