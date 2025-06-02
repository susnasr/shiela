<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Change the status column to an enum
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert to string
            $table->string('status')->default('pending')->change();
        });
    }
};
