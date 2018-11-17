<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('homepage')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
