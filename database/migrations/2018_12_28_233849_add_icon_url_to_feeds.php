<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddIconUrlToFeeds extends Migration
{
    public function up()
    {
        Schema::table('feeds', function ($table) {
            $table->string('icon_url')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('feeds', function ($table) {
            $table->dropColumn('icon_url');
        });
    }
}
