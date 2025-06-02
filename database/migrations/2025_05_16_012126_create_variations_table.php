<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Size", "Color"
            $table->timestamps();
        });

        Schema::create('variation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained();
            $table->string('value'); // e.g., "Small", "Red"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
};
