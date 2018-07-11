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
            $table->unsignedInteger('status_id')->default(0);
            $table->text('template')->nullable();
            $table->text('fantasy_name')->nullable();
            $table->text('name')->nullable();
            $table->text('text')->nullable();
            $table->text('wide')->nullable();
            $table->text('state')->nullable();
            $table->text('municipality')->nullable();
            $table->text('video_url')->nullable();
            $table->text('references')->nullable();
            $table->text('links')->nullable();
            $table->text('sender_name')->nullable();
            $table->text('sender_mail')->nullable();
            $table->text('sender_telephone')->nullable();
            $table->text('submitDate')->nullable();
            $table->foreign('status_id')->references('id')->on('plip_status');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('petitions');
    }
}
