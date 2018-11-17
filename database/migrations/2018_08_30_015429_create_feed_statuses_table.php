<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('online');
            $table->unsignedInteger('feed_id');
            $table->timestamps();

            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_statuses');
    }
}
