<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExcerptToBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('excerpt');
        });
    }
}
